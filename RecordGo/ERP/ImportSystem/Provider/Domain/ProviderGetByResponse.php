<?php

namespace ImportSystem\Provider\Domain;

use Shared\Domain\GetByResponse;

/**
 * Class ProviderGetByResponse
 * @method ProviderCollection getCollection()
 */
class ProviderGetByResponse extends GetByResponse
{
    /**
     * ProviderGetByResponse constructor.
     * @param ProviderCollection $collection
     * @param int $totalRows
     */
    public function __construct(ProviderCollection $collection, int $totalRows)
    {
        $this->collection = $collection;
        $this->totalRows = $totalRows;
    }
}
