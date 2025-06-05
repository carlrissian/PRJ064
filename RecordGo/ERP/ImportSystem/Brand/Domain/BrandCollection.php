<?php

namespace ImportSystem\Brand\Domain;

use Shared\Domain\Collection;

class BrandCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Brand::class;
    }
}
