<?php

namespace ImportSystem\ColorMIR\Domain;

use Shared\Domain\Collection;

class ColorMIRCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return ColorMIR::class;
    }
}
