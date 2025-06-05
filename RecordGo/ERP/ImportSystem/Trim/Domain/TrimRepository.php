<?php

namespace ImportSystem\Trim\Domain;

interface TrimRepository
{
    /**
     * @param TrimCriteria $criteria
     * @return TrimGetByResponse
     */
    public function getBy(TrimCriteria $criteria): TrimGetByResponse;

    /**
     * @param int $id
     * @return Trim
     */
    // public function getById(int $id): Trim;
}
