<?php

namespace ImportSystem\PurchaseType\Domain;

use Shared\Domain\Collection;

/**
 * Class PurchaseTypeCollection
 * @method PurchaseType[] getIterator()
 */
class PurchaseTypeCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return PurchaseType::class;
    }
}
