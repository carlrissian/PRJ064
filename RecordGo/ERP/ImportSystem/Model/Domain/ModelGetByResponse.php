<?php

namespace ImportSystem\Model\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class ModelGetByResponse
 * @method ModelCollection getCollection()
 */
class ModelGetByResponse extends GetByResponse
{
    /**
     * ModelGetByResponse constructor.
     * @param ModelCollection $collection
     * @param int $totalRows
     */
    public function __construct(ModelCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
