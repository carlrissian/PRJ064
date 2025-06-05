<?php

namespace ImportSystem\MotorizationType\Domain;

interface MotorizationTypeRepository
{
    /**
     * @param MotorizationTypeCriteria $criteria
     * @return MotorizationTypeGetByResponse
     */
    public function getBy(MotorizationTypeCriteria $criteria): MotorizationTypeGetByResponse;

    /**
     * @param integer $id
     * @return MotorizationType|null
     */
    // public function getById(int $id): ?MotorizationType;
}
