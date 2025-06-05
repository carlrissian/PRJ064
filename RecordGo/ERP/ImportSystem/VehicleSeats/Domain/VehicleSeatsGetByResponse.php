<?php

namespace ImportSystem\VehicleSeats\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class VehicleSeatsGetByResponse
 * @method VehicleSeatsCollection getCollection()
 */

class VehicleSeatsGetByResponse extends GetByResponse
{
    /**
     * VehicleSeatsGetByResponse constructor.
     * @param VehicleSeatsCollection $collection
     * @param int $totalRows
     */
    public function __construct(VehicleSeatsCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
