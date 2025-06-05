<?php

namespace ImportSystem\Provider\Domain;

use Shared\Domain\Criteria\Criteria;

class ProviderCriteria extends Criteria
{
    public function getAllowedFields(): array
    {
        return [
            'code',
            'name',
            'cif',
            'stateId',
            'providerTypeId'
        ];
    }
}
