<?php

namespace ImportSystem\GearBox\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\GearBox\Domain\GearBoxCriteria;
use ImportSystem\GearBox\Domain\GearBoxRepository;

class SelectListGearBoxQueryHandler
{
    /**
     * @var GearBoxRepository
     */
    private $gearBoxRepository;

    /**
     * SelectListGearBoxQueryHandler constructor.
     *
     * @param GearBoxRepository $gearBoxRepository
     */
    public function __construct(GearBoxRepository $gearBoxRepository)
    {
        $this->gearBoxRepository = $gearBoxRepository;
    }

    /**
     * @return SelectListGearBoxResponse
     */
    public function handle(): SelectListGearBoxResponse
    {
        $gearBoxCollection = $this->gearBoxRepository->getBy(new GearBoxCriteria())->getCollection();
        return new SelectListGearBoxResponse(Utils::createCustomSelectList($gearBoxCollection, 'id', 'name', 'acrissLetter'));
    }
}
