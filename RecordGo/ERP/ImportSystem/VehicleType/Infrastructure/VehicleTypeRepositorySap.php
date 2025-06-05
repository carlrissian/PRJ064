<?php

namespace ImportSystem\VehicleType\Infrastructure;

use Shared\Repository\RepositoryHelper;
use ImportSystem\VehicleType\Domain\VehicleType;
use ImportSystem\VehicleType\Domain\VehicleTypeCriteria;
use ImportSystem\VehicleType\Domain\VehicleTypeCollection;
use ImportSystem\VehicleType\Domain\VehicleTypeRepository;
use ImportSystem\VehicleType\Domain\VehicleTypeGetByResponse;

final class VehicleTypeRepositorySap extends RepositoryHelper implements VehicleTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'VehicleType/VehicleTypeRepository';

    /**
     * @inheritDoc
     */
    final public function getBy(VehicleTypeCriteria $criteria): VehicleTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleTypeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TVehicleTypeResponse');

            foreach ($responseArray['TVehicleTypeResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToVehicleType($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new VehicleTypeGetByResponse($collection, $totalRows ?? 0);
    }


    final public function arrayToVehicleType(array $vehicleTypeArray): VehicleType
    {
        return VehicleType::createFromArray($vehicleTypeArray);
    }
}
