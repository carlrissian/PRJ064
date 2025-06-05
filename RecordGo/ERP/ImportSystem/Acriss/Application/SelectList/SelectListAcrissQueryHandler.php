<?php

namespace ImportSystem\Acriss\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\Acriss\Domain\AcrissCriteria;
use ImportSystem\Acriss\Domain\AcrissRepository;

class SelectListAcrissQueryHandler
{
    /**
     * @var AcrissRepository
     */
    private $brandRepository;

    /**
     * SelectListAcrissQueryHandler constructor.
     *
     * @param AcrissRepository $brandRepository
     */
    public function __construct(AcrissRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return SelectListAcrissResponse
     */
    public function handle(): SelectListAcrissResponse
    {
        $brandCollection = $this->brandRepository->getBy(new AcrissCriteria())->getCollection();
        return new SelectListAcrissResponse(Utils::createSelect($brandCollection));
    }
}
