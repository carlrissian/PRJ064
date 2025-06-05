<?php

namespace ImportSystem\VehicleStatus\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\VehicleStatus\Domain\VehicleStatusCriteria;
use ImportSystem\VehicleStatus\Domain\VehicleStatusRepository;

class SelectListVehicleStatusQueryHandler
{
    /**
     * @var VehicleStatusRepository
     */
    private VehicleStatusRepository $vehicleStatusRepository;

    /**
     * SelectListVehicleStatusQueryHandler constructor
     * 
     * @param VehicleStatusRepository $vehicleStatusRepository
     */
    public function __construct(VehicleStatusRepository $vehicleStatusRepository)
    {
        $this->vehicleStatusRepository = $vehicleStatusRepository;
    }

    /**
     * @return SelectListVehicleStatusResponse
     */
    public function handle(): SelectListVehicleStatusResponse
    {
        $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();
        return new SelectListVehicleStatusResponse(Utils::createSelect($vehicleStatusCollection));
    }
}
