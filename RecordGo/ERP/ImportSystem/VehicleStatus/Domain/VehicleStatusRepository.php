<?php

namespace ImportSystem\VehicleStatus\Domain;

interface VehicleStatusRepository
{
    /**
     * @param VehicleStatusCriteria $criteria
     * @return VehicleStatusGetByResponse
     */
    public function getBy(VehicleStatusCriteria $criteria): VehicleStatusGetByResponse;

    /**
     * @param integer $id
     * @return VehicleStatus|null
     */
    // public function getById(int $id): ?VehicleStatus;
}
