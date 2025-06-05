<?php

namespace ImportSystem\CarGroup\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class CarGroupGetByResponse
 * @method CarGroupCollection getCollection()
 */

class CarGroupGetByResponse extends GetByResponse
{
    /**
     * CarGroupGetByResponse constructor.
     * @param CarGroupCollection $collection
     * @param int $totalRows
     */
    public function __construct(CarGroupCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
