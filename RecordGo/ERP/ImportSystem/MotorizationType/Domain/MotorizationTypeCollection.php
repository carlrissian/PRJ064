<?php

namespace ImportSystem\MotorizationType\Domain;

use Shared\Domain\Collection;

class MotorizationTypeCollection extends Collection
{
    protected function type(): string
    {
        return MotorizationType::class;
    }
}
