<?php

namespace ImportSystem\VehicleSeats\Domain;

use Shared\Domain\Criteria\Criteria;

class VehicleSeatsCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'id',
            'value'
        ];
    }
}
