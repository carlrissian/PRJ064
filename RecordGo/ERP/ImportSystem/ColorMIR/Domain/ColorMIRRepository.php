<?php

namespace ImportSystem\ColorMIR\Domain;

interface ColorMIRRepository
{
    /**
     * @param ColorMIRCriteria $criteria
     * @return ColorMIRGetByResponse
     */
    public function getBy(ColorMIRCriteria $criteria): ColorMIRGetByResponse;

    /**
     * @param integer $id
     * @return ColorMIR|null
     */
    // public function getById(int $id): ?ColorMIR;
}
