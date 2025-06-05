<?php


namespace ImportSystem\Fleet\Domain;


use Shared\Domain\Criteria\Criteria;

/**
 * Class FleetCriteria
 * @package ImportSystem\Fleet\Domain
 */
class FleetCriteria extends Criteria
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

    /** @var string|null */
    private $nive = null;

    public function setNive(string $nive): void
    {
        $this->nive = $nive;
    }

    public function getNive(): ?string
    {
        return $this->nive;
    }


}