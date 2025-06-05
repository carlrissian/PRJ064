<?php

namespace ImportSystem\Acriss\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class AcrissGetByResponse
 * @method AcrissCollection getCollection()
 */
class AcrissGetByResponse extends GetByResponse
{
    /**
     * AcrissGetByResponse constructor.
     * @param AcrissCollection $collection
     * @param int $totalRows
     */
    public function __construct(AcrissCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
