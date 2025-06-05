<?php

namespace ImportSystem\Location\Domain;

use Shared\Domain\Criteria\Criteria;

class LocationCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'locationType',
            'branchId',
            'branchGroupId'
        ];
    }
}
