<?php
declare(strict_types=1);


namespace Shared\Constants\Domain;

use Shared\Domain\Collection;

class ConstantCollection extends Collection
{

    /**
     * @inheritDoc
     */
    protected function type(): string
    {
        return Constant::class;
    }
}