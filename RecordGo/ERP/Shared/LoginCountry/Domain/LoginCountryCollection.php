<?php

declare(strict_types=1);

namespace Shared\LoginCountry\Domain;

use Shared\Domain\Collection;

/**
 * Class LocationTypeCollection
 * @method LoginCountry[] getIterator()
 */
class LoginCountryCollection extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return LoginCountry::class;
    }
}
