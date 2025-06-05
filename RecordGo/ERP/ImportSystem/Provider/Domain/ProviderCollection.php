<?php

namespace ImportSystem\Provider\Domain;

use Shared\Domain\Collection;

/**
 * Class ProviderCollection
 * @method Provider[] getIterator()
 */
class ProviderCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Provider::class;
    }
}
