<?php

namespace ImportSystem\Model\Infrastructure;

use ImportSystem\Model\Domain\Model;
use Shared\Repository\RepositoryHelper;
use ImportSystem\Model\Domain\ModelCriteria;
use ImportSystem\Model\Domain\ModelCollection;
use ImportSystem\Model\Domain\ModelRepository;
use ImportSystem\Model\Domain\ModelGetByResponse;

final class ModelRepositorySap extends RepositoryHelper implements ModelRepository
{
    private const PREFIX_FUNCTION_NAME = 'Model/ModelRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(ModelCriteria $criteria): ModelGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new ModelCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TModelResponse');

            foreach ($responseArray['TModelResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToModel($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new ModelGetByResponse($collection, $totalRows ?? 0);
    }

    // public function getById(int $id): ?Model
    // {
    //     // TODO: Implement getById() method.
    // }


    final private function arrayToModel(array $modelArray): Model
    {
        return Model::createFromArray($modelArray);
    }
}
