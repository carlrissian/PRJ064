<?php

declare(strict_types=1);

namespace Shared\Constants\Domain;

interface ConstantsRepository
{
    /**
     * @param ConstantsCriteria $criteria
     * @return ConstantCollection
     */
    public function getBy(ConstantsCriteria $criteria): ConstantCollection;
}
