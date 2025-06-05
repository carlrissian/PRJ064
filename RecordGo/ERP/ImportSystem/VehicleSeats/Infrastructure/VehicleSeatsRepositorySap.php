<?php

namespace ImportSystem\VehicleSeats\Infrastructure;

use Shared\Repository\RepositoryHelper;
use ImportSystem\VehicleSeats\Domain\VehicleSeats;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsCriteria;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsCollection;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsRepository;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsGetByResponse;

final class VehicleSeatsRepositorySap extends RepositoryHelper implements VehicleSeatsRepository
{
    private const PREFIX_FUNCTION_NAME = 'CarSeats/CarSeatsRepository';

    /**
     * @inheritDoc
     */
    final public function getBy(VehicleSeatsCriteria $criteria): VehicleSeatsGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleSeatsCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TCarSeatsResponse');

            foreach ($responseArray['TCarSeatsResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicleSeats($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new VehicleSeatsGetByResponse($collection, $totalRows ?? 0);
    }


    final public function arrayToVehicleSeats(array $vehicleSeatsArray): VehicleSeats
    {
        return VehicleSeats::createFromArray($vehicleSeatsArray);
    }
}
