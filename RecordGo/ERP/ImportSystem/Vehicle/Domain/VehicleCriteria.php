<?php


namespace ImportSystem\Vehicle\Domain;


use Shared\Domain\Criteria\Criteria;

/**
 * Class VehicleCriteria
 * @package ImportSystem\Vehicle\Domain
 */
class VehicleCriteria extends Criteria
{
    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public function getAllowedFields(): array
    {
        return [
            'LICENSEPLATE'
        ];
    }
}