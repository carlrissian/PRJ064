<?php

namespace ImportSystem\Vehicle\Application\ExportExcelVehicle;

use ImportSystem\Vehicle\Domain\Vehicle;
use ImportSystem\Vehicle\Domain\VehicleCriteria;
use ImportSystem\Vehicle\Domain\VehicleRepository;
use ImportSystem\VehicleStatus\Domain\VehicleStatus;
use ImportSystem\VehicleStatus\Domain\VehicleStatusCriteria;
use ImportSystem\VehicleStatus\Domain\VehicleStatusRepository;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class ExportExcelVehicleCommandHandler
{
    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    /**
     * @var VehicleStatusRepository $vehicleStatusRepository
     */
    private $vehicleStatusRepository;

    /**
     * @param VehicleRepository $vehicleRepository
     * @param VehicleStatusRepository $vehicleStatusRepository
     */
    public function __construct(VehicleRepository $vehicleRepository, VehicleStatusRepository $vehicleStatusRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->vehicleStatusRepository = $vehicleStatusRepository;
    }


    /**
     * @param ExportExcelVehicleCommand $query
     * @return ExportExcelVehicleResponse
     */
    public function handle(): ExportExcelVehicleResponse
    {

        $allStatusResponse= $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria());
        $vehicleGetByResponse = $this->vehicleRepository->getBy(new VehicleCriteria());

        $vehicleList = [];
        /**
         * @var Vehicle $vehicle
         */
        foreach ($vehicleGetByResponse->getCollection() as $vehicle) {
            $vehicleList[] = [
                'matricula' => ['title' => 'License Plate', "value" => $vehicle->getLicensePlate()],
                'estado' => ['title' => 'Status', "value" => $vehicle->getVehicleStatus()->getName()],
                'kmsActuales' => ['title' => 'Actual Kms', "value" => $vehicle->getActualKms()],
                'combustibleActual' => ['title' => 'Tank Actual Octaves', "value" => $vehicle->getActualCombustible()],
                'bateriaActual' => ['title' => 'Batery Actual', "value" => $vehicle->getActualBateria()]
            ];
        }

        $vehicleStatusList=[];
        /**
         * @var VehicleStatus $vehicleStatus
         */
        foreach ($allStatusResponse->getCollection() as $vehicleStatus){
            $vehicleStatusList[]=['status'=>$vehicleStatus->getName(),'id'=>$vehicleStatus->getId()];
        }


        return new ExportExcelVehicleResponse($vehicleList,$vehicleStatusList);
    }
}