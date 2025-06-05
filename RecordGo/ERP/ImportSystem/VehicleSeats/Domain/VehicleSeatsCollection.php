<?php

namespace ImportSystem\VehicleSeats\Domain;

use Shared\Domain\Collection;

class VehicleSeatsCollection extends Collection
{
    protected function type(): string
    {
        return VehicleSeats::class;
    }
}
