<?php

namespace ImportSystem\VehicleSeats\Application\SelectList;

use Shared\Utils\Utils;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsCriteria;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsRepository;

class SelectListVehicleSeatsQueryHandler
{
    /**
     * @var VehicleSeatsRepository
     */
    private $vehicleSeatsRepository;

    /**
     * SelectListVehicleSeatsQueryHandler constructor.
     *
     * @param VehicleSeatsRepository $vehicleSeatsRepository
     */
    public function __construct(VehicleSeatsRepository $vehicleSeatsRepository)
    {
        $this->vehicleSeatsRepository = $vehicleSeatsRepository;
    }

    /**
     * @return SelectListVehicleSeatsResponse
     */
    public function handle(): SelectListVehicleSeatsResponse
    {
        $vehicleSeatsCollection = $this->vehicleSeatsRepository->getBy(new VehicleSeatsCriteria())->getCollection();
        return new SelectListVehicleSeatsResponse(Utils::createSelect($vehicleSeatsCollection));
    }
}
