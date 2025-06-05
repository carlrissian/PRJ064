<?php

namespace ImportSystem\Trim\Infrastructure;

use ImportSystem\Trim\Domain\Trim;
use Shared\Repository\RepositoryHelper;
use ImportSystem\Trim\Domain\TrimCriteria;
use ImportSystem\Trim\Domain\TrimCollection;
use ImportSystem\Trim\Domain\TrimRepository;
use ImportSystem\Trim\Domain\TrimGetByResponse;

final class TrimRepositorySap extends RepositoryHelper implements TrimRepository
{
    private const PREFIX_FUNCTION_NAME = 'Trim/TrimRepository';

    /**
     * @inheritDoc
     */
    public function getBy(TrimCriteria $criteria): TrimGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new TrimCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TTrimResponse');

            foreach ($responseArray['TTrimResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToTrim($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new TrimGetByResponse($collection, $totalRows ?? 0);
    }

    // public function getById(int $id): Trim
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

    //     try {
    //         $trimArray = $this->genericGetById('GET', $functionName, 'TTrimResponse');
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }

    //     return $this->arrayToTrim($trimArray);
    // }


    final public function arrayToTrim(array $trimArray): Trim
    {
        return Trim::createFromArray($trimArray);
    }
}
