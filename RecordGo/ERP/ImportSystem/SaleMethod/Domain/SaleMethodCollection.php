<?php

namespace ImportSystem\SaleMethod\Domain;

use Shared\Domain\Collection;

/**
 * Class SaleMethodCollection
 * @method SaleMethod[] getIterator()
 */
class SaleMethodCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return SaleMethod::class;
    }
}
