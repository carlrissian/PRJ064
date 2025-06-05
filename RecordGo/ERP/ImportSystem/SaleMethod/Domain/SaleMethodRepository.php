<?php

namespace ImportSystem\SaleMethod\Domain;

interface SaleMethodRepository
{
    /**
     * @param SaleMethodCriteria $criteria
     * @return SaleMethodGetByResponse
     */
    public function getBy(SaleMethodCriteria $criteria): SaleMethodGetByResponse;
}
