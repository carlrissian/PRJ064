<?php

namespace ImportSystem\Acriss\Domain;

use Shared\Domain\Collection;

class AcrissCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Acriss::class;
    }
}