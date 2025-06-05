<?php
declare(strict_types=1);


namespace Shared\Constants\Application\FilterConstants;

use Shared\Constants\Domain\ConstantsCriteria;
use Shared\Constants\Domain\ConstantsRepository;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class FilterConstantsQueryHandler
{
    const FILTER_KEY = 'NAME';

    /**
     * @var ConstantsRepository
     */
    private ConstantsRepository $constantsRepository;


    /**
     * GetTrimHandler constructor.
     * @param ConstantsRepository $constantsRepository
     */
    public function __construct(ConstantsRepository $constantsRepository)
    {
        $this->constantsRepository = $constantsRepository;
    }

    public function handle()
    {
        $filterCollection = new FilterCollection([
            new Filter(
                self::FILTER_KEY,
                new FilterOperator(FilterOperator::EQUAL),
                $_ENV['CONSTANTS_KEY_SATELLITE']
            )
        ]);

        $constantsCollection = $this->constantsRepository->getBy(
            new ConstantsCriteria($filterCollection)
        );

        $constantsArray= [];
        foreach ($constantsCollection as $constant) {
            //Montar json
            $constantsArray[$constant->getKey()] = $constant->getValue();
        }

        // crear o sobreescribir constants.json
        ConstantsJsonFile::write($constantsArray);
    }
}