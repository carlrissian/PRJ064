<?php

namespace ImportSystem\Fleet\Domain;

use Shared\Domain\Collection;

/**
 * Class AnexoLineCollection
 * @method AnexoLine getIterator()
 */
final class AnexoLineCollection extends Collection
{
    protected function type(): string
    {
        return AnexoLine::class;
    }

}