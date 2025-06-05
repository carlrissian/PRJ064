<?php

namespace ImportSystem\Location\Domain;

use Shared\Domain\Collection;

class LocationCollection extends Collection
{
    protected function type(): string
    {
        return Location::class;
    }
}
