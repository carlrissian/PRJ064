<?php

namespace ImportSystem\Trim\Domain;

use Shared\Domain\Collection;

class TrimCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Trim::class;
    }
}
