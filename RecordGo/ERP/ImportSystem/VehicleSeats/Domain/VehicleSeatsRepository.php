<?php

namespace ImportSystem\VehicleSeats\Domain;

interface VehicleSeatsRepository
{
    /**
     * @param VehicleSeatsCriteria $criteria
     * @return VehicleSeatsGetByResponse
     */
    public function getBy(VehicleSeatsCriteria $criteria): VehicleSeatsGetByResponse;
}
