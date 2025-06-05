<?php


namespace ImportSystem\Fleet\Domain;


use Shared\Domain\GetByResponse;

class FleetGetByResponse extends GetByResponse
{
    /**
     * @param FleetCollection $collection
     * @param int $totalRows
     */
    public function __construct(FleetCollection $collection,int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}