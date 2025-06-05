<?php

namespace ImportSystem\Acriss\Infrastructure;

use ImportSystem\Acriss\Domain\Acriss;
use Shared\Repository\RepositoryHelper;
use ImportSystem\Acriss\Domain\AcrissCriteria;
use ImportSystem\Acriss\Domain\AcrissCollection;
use ImportSystem\Acriss\Domain\AcrissRepository;
use ImportSystem\Acriss\Domain\AcrissGetByResponse;

final class AcrissRepositorySap extends RepositoryHelper implements AcrissRepository
{
    private const PREFIX_FUNCTION_NAME = 'Acriss/AcrissRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(AcrissCriteria $criteria): AcrissGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new AcrissCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TAcrissResponse');

            foreach ($responseArray['TAcrissResponse'] as $itemArray) {
                $collection->add($this->arrayToAcriss($itemArray));
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new AcrissGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function getById(int $id): Acriss
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

    //     try {
    //         $response  = $this->sapRequestHelper->request('GET', $functionName, '');
    //         $responseArray = json_decode($response, true);

    //         return count($responseArray['TAcrissResponse']) > 0 ? $this->arrayToAcriss($responseArray['TAcrissResponse'][0]) : null;
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function store(Acriss $acriss): int
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

    //     try {
    //         $body = json_encode($acriss->toArray());

    //         $response = $this->sapRequestHelper->request('POST', $functionName, $body);
    //         $responseArray = json_decode($response, true);

    //         return intval($responseArray['ID']);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }

    //     return $response;
    // }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function update(Acriss $acriss): int
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $acriss->getId();

    //     try {
    //         $body = json_encode($acriss->toArray());

    //         $response = $this->sapRequestHelper->request('PATCH', $functionName, $body);
    //         $responseArray = json_decode($response, true);

    //         return intval($responseArray['ID']);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }

    //     return $response;
    // }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function checkIsOnBooking(AcrissCriteria $criteria): ?bool
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_OnBooking';

    //     try {
    //         $body = json_encode(parent::createCriteria($criteria));

    //         $response = $this->sapRequestHelper->request('GET', $functionName, $body);

    //         if ($response === false) {
    //             throw new Exception("The onBooking request hasn't returned a response", 500);
    //         }

    //         $responseArray = json_decode($response, true);
    //         $this->errorHandling($responseArray, $response, 'ISONBOOKING');
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }

    //     return filter_var($responseArray['ISONBOOKING'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    // }


    /**
     * @param array $acrissArray
     * @return Acriss
     */
    final private function arrayToAcriss(array $acrissArray): Acriss
    {
        return Acriss::createFromArray($acrissArray);
    }
}
