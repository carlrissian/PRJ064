<?php

namespace ImportSystem\VehicleType\Domain;

use Shared\Domain\Criteria\Criteria;

class VehicleTypeCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'id',
            'name'
        ];
    }
}
