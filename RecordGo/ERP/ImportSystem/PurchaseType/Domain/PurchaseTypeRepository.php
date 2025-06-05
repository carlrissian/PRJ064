<?php

namespace ImportSystem\PurchaseType\Domain;

interface PurchaseTypeRepository
{
    /**
     * @param PurchaseTypeCriteria $criteria
     * @return PurchaseTypeGetByResponse
     */
    public function getBy(PurchaseTypeCriteria $criteria): PurchaseTypeGetByResponse;
}
