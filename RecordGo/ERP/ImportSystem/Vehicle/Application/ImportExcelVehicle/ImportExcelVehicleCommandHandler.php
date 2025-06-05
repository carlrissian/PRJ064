<?php

namespace ImportSystem\Vehicle\Application\ImportExcelVehicle;

use ImportSystem\Vehicle\Domain\Vehicle;
use Shared\Domain\Logs\GrafanaLogHelper;
use ImportSystem\Vehicle\Domain\VehicleStatus;
use ImportSystem\Vehicle\Domain\VehicleCriteria;
use ImportSystem\Vehicle\Domain\VehicleRepository;
use ImportSystem\VehicleStatus\Domain\VehicleStatusCriteria;
use ImportSystem\VehicleStatus\Domain\VehicleStatusRepository;

class ImportExcelVehicleCommandHandler
{
    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    /**
     * @var VehicleStatusRepository
     */
    private $vehicleStatusRepository;

    /**
     * @var array $errors
     */
    public $errors;

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
     * @param ImportExcelVehicleCommand $vehicleCommand
     * @return array
     */
    public function handle(ImportExcelVehicleCommand $vehicleCommand): array
    {
        $vehicleArray = $vehicleCommand->getArray()['items'];
        $allVehicles = $vehicleCommand->getArray()['vehicles'];
        $vehicleStatusList = $vehicleCommand->getArray()['vehicleStatusList'];

        $logHelper = new GrafanaLogHelper();
        $logHelper->log('POST', 200, 'Load file Import Vehicle', 'Load array vehicle', 'INFO');

        $allLicensePlate = $this->repeatValueArray($vehicleArray);
        $repeatLicensePlate = array_count_values($allLicensePlate);


        $listVehiclesUpdate = [];
        if (count($vehicleArray) > 0) {
            // $allVehicles = $this->vehicleRepository->getBy(new VehicleCriteria())->getCollection()->toArray();   // FILTER MATRICULA
            // $allStatus = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection()->toArray(); // FILTER STATUS

            foreach ($vehicleArray as $vehicleIndex => $vehicleItem) {
                $validateRow = false;
                $indexExcel = $vehicleIndex + 2;

                [$matricula, $estado, $kmsActuales, $combustible, $bateria] = null;
                foreach ($vehicleItem as $index => $item) {
                    switch ($index) {
                            // Matrícula
                        case 0:
                            $matricula = $item;
                            break;
                            // Estado
                        case 1:
                            $estado = $item;
                            break;
                            // Kms actuales
                        case 2:
                            $kmsActuales = $item;
                            break;
                            // Combustible
                        case 3:
                            $combustible = $item;
                            break;
                            // Batería
                        case 4:
                            $bateria = $item;
                            break;
                            // Index (line excel)
                            // case 5:
                            //     $indexExcel = $item;
                            //     break;

                        default:
                            $validateRow = $this->validateRow("Unknown column {$item} in the excel in the line {$indexExcel}. Please review the document.");
                            break;
                    }
                }

                $validateLicensePlate = $this->licensePlateExists($matricula, $allVehicles);
                $validateVehicleStatus = $this->statusExists($estado, $vehicleStatusList);

                if ($repeatLicensePlate[$matricula] > 1) {
                    $validateRow = $this->validateRow("The license plate {$matricula} is repeated in the excel in the line {$indexExcel}. Please review the document. ");
                }

                if (empty($validateLicensePlate)) {
                    $validateRow = $this->validateRow("No exists licenseplate {$matricula} in data base in line {$indexExcel}");
                }
                if (empty($validateVehicleStatus)) {
                    $validateRow = $this->validateRow("No exists status {$estado} in data base in line {$indexExcel}");
                }

                if (empty($matricula)) {
                    $validateRow = $this->validateRow("In the row {$indexExcel} license plate is required");
                } else if (!is_string($matricula)) {
                    $validateRow = $this->validateRow("In the row {$indexExcel} license plate {$matricula} must be text");
                }

                if (!is_int($kmsActuales)) {
                    $validateRow = $this->validateRow("In the row {$indexExcel} current kms {$kmsActuales} must be number");
                }

                if (!is_int($combustible)) {
                    $validateRow = $this->validateRow("In the row {$indexExcel} tank octaves {$combustible} must be number");
                }

                if (!is_float($bateria)) {
                    $validateRow = $this->validateRow("In the row {$indexExcel} battery {$bateria} must be decimal");
                }

                if (!is_string($estado)) {
                    $validateRow = $this->validateRow("In the row {$indexExcel} status {$estado} must be text");
                }

                if (!$validateRow) {
                    $vehicleArray = $this->updateVehicle($vehicleItem);
                    array_push($listVehiclesUpdate, $vehicleArray);
                    // $this->vehicleRepository->update($vehicleArray);
                }
            }

            $message = empty($this->errors) ? "The update process has been completed successfully" : "The update process completed successfully, but there are errors: ";


            return [['message' => $message, 'listVehiclesUpdate' => $listVehiclesUpdate, 'errors' => $this->errors]];
        }

        return [['message' => 'Error loading xls']];
    }

    /**
     * @param array $vehicle
     * @return Vehicle
     */
    private function updateVehicle(array $vehicle): Vehicle
    {
        $vehicleObject = new Vehicle(
            null,
            $vehicle[0],
            new VehicleStatus(null, $vehicle[1]),
            $vehicle[2],
            $vehicle[3],
            $vehicle[4]
        );
        return $vehicleObject;
    }

    /**
     * @param $licensePlate
     * @param $allVehicles
     * @return array
     */
    public function licensePlateExists($licensePlate, $allVehicles)
    {
        $value = array_filter($allVehicles, function ($filter) use ($licensePlate) {
            return $filter['matricula']['value'] == $licensePlate;
        });
        return $value;
    }

    /**
     * @param $status
     * @param $allStatus
     * @return array
     */
    public function statusExists($status, $allStatus)
    {
        $value = array_filter($allStatus, function ($filter) use ($status) {
            return $filter['status'] == $status;
        });
        return $value;
    }


    /**
     * @param array $vehicleArray
     * @return array
     */
    public function repeatValueArray(array $vehicleArray)
    {
        $licensePlate = [];
        foreach ($vehicleArray as $item) {
            if (!is_null($item[0])) {
                array_push($licensePlate, $item[0]);
            }
        }
        return $licensePlate;
    }

    public function validateRow(string $message)
    {
        $this->errors[] = $message;
        return true;
    }
}
