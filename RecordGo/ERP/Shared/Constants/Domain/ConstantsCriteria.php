<?php
declare(strict_types=1);


namespace Shared\Constants\Domain;


use Shared\Domain\Criteria\Criteria;

class ConstantsCriteria extends Criteria
{

    /**
     * @inheritDoc
     */
    public function getAllowedFields(): array
    {
        return [
            'SATELLITE'
        ];
    }
}