<?php

namespace ImportSystem\VehicleStatus\Domain;

use Shared\Domain\Collection;

class VehicleStatusCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return VehicleStatus::class;
    }
}
