<?php

namespace ImportSystem\Vehicle\Domain;



use Shared\Utils\DataValidation;


/**
 * Class Vehicle
 * @package Plantilla\Vehicle\Domain
 */
class Vehicle
{
    /**
     * @var null|int
     */
    private $id;

    /**
     * @var string
     */
    private $licensePlate;

    /**
     * @var VehicleStatus
     */
    private $vehicleStatus;

    /**
     * @var int
     */
    private $actualKms;

    /**
     * @var null|int
     */
    private $actualCombustible;

    /**
     * @var null|float
     */
    private $actualBateria;

    /**
     * @param null|int $id
     * @param string $licensePlate
     * @param VehicleStatus $vehicleStatus
     * @param null|int $actualKms
     * @param null|int $actualCombustible
     * @param null|float $actualBateria
     */
    public function __construct(?int $id,string $licensePlate, VehicleStatus $vehicleStatus, ?int $actualKms,? int $actualCombustible,? float $actualBateria)
    {
        $this->id = $id;
        $this->licensePlate = $licensePlate;
        $this->vehicleStatus = $vehicleStatus;
        $this->actualKms = $actualKms;
        $this->actualCombustible = $actualCombustible;
        $this->actualBateria = $actualBateria;

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLicensePlate(): string
    {
        return $this->licensePlate;
    }

    /**
     * @return VehicleStatus
     */
    public function getVehicleStatus(): VehicleStatus
    {
        return $this->vehicleStatus;
    }

    /**
     * @return int|null
     */
    public function getActualKms(): ?int
    {
        return $this->actualKms;
    }


    /**
     * @return int|null
     */
    public function getActualCombustible(): ?int
    {
        return $this->actualCombustible;
    }

    /**
     * @return float|null
     */
    public function getActualBateria(): ?float
    {
        return $this->actualBateria;
    }


    public static function createFromArray(array $arrayVehicle):Vehicle
    {
        $helper = new DataValidation();

        $vehicleStatus=($arrayVehicle['VehicleStatus'] !== null)?VehicleStatus::createFromArraySAP($arrayVehicle['VehicleStatus']) : null;

        $vehicle = new self(
            $helper->intOrNull($helper->arrayExistOrNull($arrayVehicle, 'ID')),
            $helper->arrayExistOrNull($arrayVehicle, 'LICENSEPLATE'),
            $vehicleStatus,
            $helper->arrayExistOrNull($arrayVehicle, 'ACTUALKMS'),
            $helper->arrayExistOrNull($arrayVehicle, 'TANKACTUALOCTAVES'),
            $helper->floatOrNull($helper->arrayExistOrNull($arrayVehicle, 'BATERYACTUAL')),
        );

        return $vehicle;

    }

    public static function createToArray(self $vehicle)
    {

        $vehicleBody = [
            'LICENSEPLATE' => $vehicle->getLicensePlate(),
            "STATUSNAME" => $vehicle->vehicleStatus->getName(),
            'TANKACTUALOCTAVES' => $vehicle->getActualCombustible(),
            'BATERYACTUAL' => $vehicle->getActualBateria(),
            "FIRSTRENTDATE"=>null,
            'RENTINGENDDATE' => null,
            'ACTUALKMS' => $vehicle->getActualKms(),

        ];

        return $vehicleBody;
    }



}