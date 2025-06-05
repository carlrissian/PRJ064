<?php

namespace ImportSystem\Trim\Domain;

use Shared\Domain\Criteria\Criteria;

class TrimCriteria extends Criteria
{
    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [];
    }
}
