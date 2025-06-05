<?php

namespace ImportSystem\CarGroup\Domain;

/**
 * Interface CarGroupRepository
 * @package ImportSystem\CarGroup\Domain
 */
interface CarGroupRepository
{
    /**
     * @param CarGroupCriteria $criteria
     * @return CarGroupGetByResponse
     */
    public function getBy(CarGroupCriteria $criteria): CarGroupGetByResponse;

    /**
     * @param int $id
     * @return CarGroup|null
     */
    // public function getById(int $id): ?CarGroup;

    /**
     * @param CarGroup $carGroup
     * @return int
     */
    // public function store(CarGroup $carGroup): int;

    /**
     * @param CarGroup $carGroup
     * @return int
     */
    // public function update(CarGroup $carGroup): int;
}
