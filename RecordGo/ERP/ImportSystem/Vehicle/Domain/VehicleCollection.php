<?php


namespace ImportSystem\Vehicle\Domain;


use Shared\Domain\Collection;

class VehicleCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return Vehicle::class;
    }
}