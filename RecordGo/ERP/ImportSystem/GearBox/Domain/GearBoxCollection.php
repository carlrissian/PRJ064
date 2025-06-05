<?php

namespace ImportSystem\GearBox\Domain;

use Shared\Domain\Collection;

class GearBoxCollection extends Collection
{
    protected function type(): string
    {
        return GearBox::class;
    }
}
