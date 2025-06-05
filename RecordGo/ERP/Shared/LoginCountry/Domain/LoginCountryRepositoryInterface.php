<?php

declare(strict_types=1);

namespace Shared\LoginCountry\Domain;

interface LoginCountryRepositoryInterface
{
    /**
     * @return LoginCountryCollection
     */
    public function getAll(): LoginCountryCollection;
}
