<?php

namespace ImportSystem\VehicleType\Domain;

interface VehicleTypeRepository
{
    /**
     * @param VehicleTypeCriteria $criteria
     * @return VehicleTypeGetByResponse
     */
    public function getBy(VehicleTypeCriteria $criteria): VehicleTypeGetByResponse;
}
