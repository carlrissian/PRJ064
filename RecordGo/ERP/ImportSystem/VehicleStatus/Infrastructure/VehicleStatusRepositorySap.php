<?php

namespace ImportSystem\VehicleStatus\Infrastructure;

use Shared\Repository\RepositoryHelper;
use ImportSystem\VehicleStatus\Domain\VehicleStatus;
use ImportSystem\VehicleStatus\Domain\VehicleStatusCriteria;
use ImportSystem\VehicleStatus\Domain\VehicleStatusCollection;
use ImportSystem\VehicleStatus\Domain\VehicleStatusRepository;
use ImportSystem\VehicleStatus\Domain\VehicleStatusGetByResponse;

final class VehicleStatusRepositorySap extends RepositoryHelper implements VehicleStatusRepository
{
    private const PREFIX_FUNCTION_NAME = 'VehicleStatus/VehicleStatusRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(VehicleStatusCriteria $criteria): VehicleStatusGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleStatusCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TVehicleStatusResponse');

            foreach ($responseArray['TVehicleStatusResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicleStatus($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new VehicleStatusGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function getById(int $id): ?VehicleStatus
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

    //     try {
    //         $carArray = $this->genericGetById('GET', $functionName, 'TVehicleStatusResponse');

    //         return $this->arrayToVehicleStatus($carArray);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }


    /**
     * @throws Exception
     */
    final public function arrayToVehicleStatus(array $vehicleStatusArray): VehicleStatus
    {
        return VehicleStatus::createFromArray($vehicleStatusArray);
    }
}
