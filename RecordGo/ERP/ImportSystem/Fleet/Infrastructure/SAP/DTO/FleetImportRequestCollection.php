<?php

namespace ImportSystem\Fleet\Infrastructure\SAP\DTO;

use Shared\Domain\Collection;

/**
 * Class FleetImportRequestCollection
 * @method FleetImportRequest getIterator()
 */
final class FleetImportRequestCollection extends Collection
{
    protected function type(): string
    {
        return FleetImportRequest::class;
    }

}