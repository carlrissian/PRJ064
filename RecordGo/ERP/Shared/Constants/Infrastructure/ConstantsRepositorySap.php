<?php

declare(strict_types=1);

namespace Shared\Constants\Infrastructure;

use Exception;
use Shared\Constants\Domain\Constant;
use Shared\Constants\Domain\ConstantCollection;
use Shared\Constants\Domain\ConstantsCriteria;
use Shared\Constants\Domain\ConstantsRepository;
use Shared\Repository\RepositoryHelper;

class ConstantsRepositorySap extends RepositoryHelper implements ConstantsRepository
{
    private const PREFIX_FUNCTION_NAME = 'Constants/ConstantsListRepository';

    /**
     * @inheritDoc
     * @throws Exception
     * @return ConstantCollection
     */
    final public function getBy(ConstantsCriteria $criteria): ConstantCollection
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_getBy';
        $collection = new ConstantCollection([]);

        $body = self::createCriteria($criteria);

        $body = json_encode($body);
        $response = $this->sapRequestHelper->request('GET', $functionName, $body, [],false);
        $responserArray = json_decode($response, true);

        if(!isset($responserArray['TConstantsResponse'])) {
            return $collection;
        }

        foreach ($responserArray['TConstantsResponse'] as $constant) {
            $collection->add(
                new Constant(
                    $constant['NAME'],
                    $constant['VALUE']
                ));
        }

        return $collection;
    }

}
