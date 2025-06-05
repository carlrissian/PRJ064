<?php


namespace ImportSystem\Vehicle\Domain;


use Shared\Domain\GetByResponse;

class VehicleGetByResponse extends GetByResponse
{
    /**
     * VehicleGetByResponse constructor.
     * @param VehicleCollection $collection
     * @param int $totalRows
     */

    public function __construct(VehicleCollection  $collection,int $totalRows)
    {
        $this->collection= $collection;
        $this->totalRows= $totalRows;
    }
}