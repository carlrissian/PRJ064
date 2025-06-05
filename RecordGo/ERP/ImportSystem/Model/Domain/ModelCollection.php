<?php

namespace ImportSystem\Model\Domain;

use Shared\Domain\Collection;

class ModelCollection extends Collection
{
    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Model::class;
    }
}
