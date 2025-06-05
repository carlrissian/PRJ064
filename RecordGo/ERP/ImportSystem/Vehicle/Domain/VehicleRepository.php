<?php


namespace ImportSystem\Vehicle\Domain;



use ImportSystem\Vehicle\Domain\Vehicle;
use ImportSystem\Vehicle\Domain\VehicleCriteria;
use ImportSystem\Vehicle\Domain\VehicleGetByResponse;

/**
 * Interface VehicleRepository
 * @package ImportSystem\Vehicle\Domain
 */
interface VehicleRepository
{

    /**
     * @param VehicleCriteria $vehicleCriteria
     * @return VehicleGetByResponse
     */
    public function getBy(VehicleCriteria $vehicleCriteria): VehicleGetByResponse;

    /**
     * @param Vehicle $vehicle
     * @return Vehicle
     */
    public function update(Vehicle $vehicle): int;


}