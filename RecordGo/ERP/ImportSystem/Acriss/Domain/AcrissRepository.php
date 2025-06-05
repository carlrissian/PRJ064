<?php

namespace ImportSystem\Acriss\Domain;

interface AcrissRepository
{
    /**
     * @param AcrissCriteria $acrissCriteria
     * @return AcrissGetByResponse
     */
    public function getBy(AcrissCriteria $acrissCriteria): AcrissGetByResponse;

    /**
     * @param AcrissCriteria $criteria
     * @return AcrissGetByResponse
     */
    // public function getAcrissToAssociate(AcrissCriteria $criteria): AcrissGetByResponse;

    /**
     * @param int $id
     * @return Acriss
     */
    // public function getById(int $id): Acriss;

    /**
     * @param Acriss $acriss
     * @return int
     */
    // public function store(Acriss $acriss): int;

    /**
     * @param Acriss $acriss
     * @return int
     */
    // public function update(Acriss $acriss): int;

    /**
     * @param AcrissCriteria $id
     * @return bool
     */
    // public function checkIsOnBooking(AcrissCriteria $id): ?bool;
}
