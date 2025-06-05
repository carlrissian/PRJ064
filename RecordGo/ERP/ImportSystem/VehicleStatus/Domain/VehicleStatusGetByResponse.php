<?php

namespace ImportSystem\VehicleStatus\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class VehicleStatusGetByResponse
 * @method VehicleStatusCollection getCollection()
 */
class VehicleStatusGetByResponse extends GetByResponse
{
    /**
     * VehicleStatusGetByResponse constructor.
     * 
     * @param VehicleStatusCollection $collection
     * @param int $totalRows
     */
    public function __construct(VehicleStatusCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
