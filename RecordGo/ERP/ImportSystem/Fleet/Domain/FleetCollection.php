<?php


namespace ImportSystem\Fleet\Domain;


use Shared\Domain\Collection;

class FleetCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return Fleet::class;
    }
}