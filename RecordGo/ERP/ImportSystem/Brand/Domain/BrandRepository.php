<?php

namespace ImportSystem\Brand\Domain;

interface BrandRepository
{
    /**
     * @param BrandCriteria $criteria
     * @return BrandGetByResponse
     */
    public function getBy(BrandCriteria $criteria): BrandGetByResponse;

    /**
     * @param integer $id
     * @return Brand|null
     */
    // public function getById(int $id): ?Brand;
}
