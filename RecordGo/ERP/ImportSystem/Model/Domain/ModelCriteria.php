<?php

namespace ImportSystem\Model\Domain;

use Shared\Domain\Criteria\Criteria;

class ModelCriteria extends Criteria
{
    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [];
    }
}
