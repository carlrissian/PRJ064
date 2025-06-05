<?php

namespace ImportSystem\SaleMethod\Domain;

use Shared\Domain\GetByResponse;

class SaleMethodGetByResponse extends GetByResponse
{
    /**
     * SaleMethodGetByResponse constructor.
     * 
     * @param SaleMethodCollection $collection
     * @param int $totalRows
     */
    public function __construct(SaleMethodCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
