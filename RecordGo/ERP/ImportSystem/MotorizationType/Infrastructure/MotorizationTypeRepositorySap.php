<?php

namespace ImportSystem\MotorizationType\Infrastructure;

use Shared\Repository\RepositoryHelper;
use ImportSystem\MotorizationType\Domain\MotorizationType;
use ImportSystem\MotorizationType\Domain\MotorizationTypeCriteria;
use ImportSystem\MotorizationType\Domain\MotorizationTypeCollection;
use ImportSystem\MotorizationType\Domain\MotorizationTypeRepository;
use ImportSystem\MotorizationType\Domain\MotorizationTypeGetByResponse;

final class MotorizationTypeRepositorySap extends RepositoryHelper implements MotorizationTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'MotorType/MotorTypeRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(MotorizationTypeCriteria $criteria): MotorizationTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new MotorizationTypeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TMotorTypeResponse');

            foreach ($responseArray['TMotorTypeResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToMotorizationType($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new MotorizationTypeGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     */
    // public function getById(int $id): ?MotorizationType
    // {
    //     // TODO: Implement getById() method.
    // }


    final public function arrayToMotorizationType(array $motorizationTypeArray): MotorizationType
    {
        return MotorizationType::createFromArray($motorizationTypeArray);
    }
}
