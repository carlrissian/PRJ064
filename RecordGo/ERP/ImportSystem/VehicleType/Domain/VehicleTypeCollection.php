<?php

namespace ImportSystem\VehicleType\Domain;

use Shared\Domain\Collection;

class VehicleTypeCollection extends Collection
{
    protected function type(): string
    {
        return VehicleType::class;
    }
}
