<?php

namespace ImportSystem\VehicleType\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class VehicleTypeGetByResponse
 * @method VehicleTypeCollection getCollection()
 */

class VehicleTypeGetByResponse extends GetByResponse
{
    /**
     * VehicleTypeGetByResponse constructor.
     * @param VehicleTypeCollection $collection
     * @param int $totalRows
     */
    public function __construct(VehicleTypeCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
