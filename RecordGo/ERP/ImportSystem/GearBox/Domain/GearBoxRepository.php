<?php

namespace ImportSystem\GearBox\Domain;

interface GearBoxRepository
{
    /**
     * @param GearBoxCriteria $criteria
     * @return GearBoxGetByResponse
     */
    public function getBy(GearBoxCriteria $criteria): GearBoxGetByResponse;

    /**
     * @param int $id
     * @return GearBox
     */
    // public function getById(int $id): GearBox;

}
