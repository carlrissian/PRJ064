<?php

namespace ImportSystem\CarGroup\Domain;

use Shared\Domain\Collection;

class CarGroupCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return CarGroup::class;
    }
}
