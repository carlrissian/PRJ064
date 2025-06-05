<?php

namespace ImportSystem\ColorMIR\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class ColorMIRGetByResponse
 * @method ColorMIRCollection getCollection()
 */
class ColorMIRGetByResponse extends GetByResponse
{
    /**
     * CarGroupGetByResponse constructor.
     * @param ColorMIRCollection $collection
     * @param int $totalRows
     */
    public function __construct(ColorMIRCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
