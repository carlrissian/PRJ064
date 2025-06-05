<?php

declare(strict_types=1);

namespace Shared\LoginCountry\Infrastructure;

use Exception;
use Shared\LoginCountry\Domain\LoginCountry;
use Shared\LoginCountry\Domain\LoginCountryCollection;
use Shared\LoginCountry\Domain\LoginCountryRepositoryInterface;
use Shared\Repository\RepositoryHelper;

class LoginCountryRepository extends RepositoryHelper implements LoginCountryRepositoryInterface
{
    private const PREFIX_FUNCTION_NAME = 'Country/CountryRepository';

    /**
     * @inheritDoc
     * @throws Exception
     * @return LoginCountryCollection
     */
    final public function getAll(): LoginCountryCollection
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_getLoginCountries';
        $collection = new LoginCountryCollection([]);

        try {
            $response = $this->sapRequestHelper->requestWithoutAuth('GET', $functionName, '');

            if ($response === false) {
                throw new Exception('Something fail during query');
            }

            $responseArray = json_decode($response, true);

            if (!$responseArray || !isset($responseArray['TLoginCountriesResponse'])) {
                throw new Exception('Something fail during getBy');
            }

            // $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : count($collectionArray);
            foreach ($responseArray['TLoginCountriesResponse'] as $itemArray) {
                $collection->add($this->arrayToLoginCountry($itemArray));
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return $collection;
    }

    final public function arrayToLoginCountry(array $loginCountryArray): LoginCountry
    {
        return new LoginCountry(
            $loginCountryArray['COUNTRYISO'],
            $loginCountryArray['COUNTRYDESCRIPTION'] ?? null,
            $loginCountryArray['TIMEZONE'],
            $loginCountryArray['INTERNALCODE']
        );
    }
}
