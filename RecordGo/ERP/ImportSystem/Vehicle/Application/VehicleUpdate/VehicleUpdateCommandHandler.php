<?php

namespace ImportSystem\Vehicle\Application\VehicleUpdate;

use ImportSystem\Vehicle\Domain\Vehicle;
use ImportSystem\Vehicle\Domain\VehicleRepository;


use ImportSystem\Vehicle\Domain\VehicleStatus;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class VehicleUpdateCommandHandler
{
    /**
     * @var VehicleRepository $vehicleRepository
     */
    private $vehicleRepository;

    /**
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function handler($vehicles): VehicleUpdateResponse
    {

        $process = new Process(['ls', '-lsa']);

            foreach ($vehicles as $vehicle){
                $process->start();
                while ($process->isRunning()) {
                    $updateVehicle = new Vehicle(
                        null,
                        $vehicle['licensePlate'],
                        new VehicleStatus($vehicle['vehicleStatus']['id'], $vehicle['vehicleStatus']['name']),
                        $vehicle['actualKms'],
                        $vehicle['actualCombustible'],
                        $vehicle['actualBateria'],
                    );
                    $this->vehicleRepository->update($updateVehicle);
                }
                $response = $process->getOutput();
            }



        return new VehicleUpdateResponse($response);


    }


}