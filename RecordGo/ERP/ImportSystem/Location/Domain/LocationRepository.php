<?php

namespace ImportSystem\Location\Domain;

interface LocationRepository
{
    /**
     * @param LocationCriteria $criteria
     * @return LocationGetByResponse
     */
    public function getBy(LocationCriteria $criteria): LocationGetByResponse;

    /**
     * @param integer $id
     * @return Location|null
     */
    // public function getById(int $id): ?Location;
}
