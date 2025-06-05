<?php

namespace ImportSystem\CarGroup\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\CarGroup\Domain\CarGroupCriteria;
use ImportSystem\CarGroup\Domain\CarGroupRepository;

class SelectListCarGroupQueryHandler
{
    /**
     * @var CarGroupRepository
     */
    private $carGroupRepository;

    /**
     * SelectListCarGroupQueryHandler constructor.
     *
     * @param CarGroupRepository $carGroupRepository
     */
    public function __construct(CarGroupRepository $carGroupRepository)
    {
        $this->carGroupRepository = $carGroupRepository;
    }

    /**
     * @return SelectListCarGroupResponse
     */
    public function handle(): SelectListCarGroupResponse
    {
        $carGroupCollection = $this->carGroupRepository->getBy(new CarGroupCriteria())->getCollection();
        return new SelectListCarGroupResponse(Utils::createSelect($carGroupCollection));
    }
}
