<?php

namespace ImportSystem\Vehicle\Application\ExportExcelVehicle;

use ImportSystem\Vehicle\Domain\VehicleStatus;

class ExportExcelVehicleCommand
{
    /**
     * @var string|null
     */
    private $licensePlate;

    /**
     * @var VehicleStatus|null
     */
    private $vehicleStatus;

    /**
     * @var int|null
     */
    private $actualKms;

    /**
     * @var int|null
     */
    private $actualCombustible;

    /**
     * @var float|null
     */
    private $actualBateria;

    /**
     * @param string|null $licensePlate
     * @param VehicleStatus|null $vehicleStatus
     * @param int|null $actualKms
     * @param int|null $actualCombustible
     * @param float|null $actualBateria
     */
    public function __construct(string $licensePlate = null, VehicleStatus $vehicleStatus = null, int $actualKms = null, int $actualCombustible = null, float $actualBateria = null)
    {
        $this->licensePlate = $licensePlate;
        $this->vehicleStatus = $vehicleStatus;
        $this->actualKms = $actualKms;
        $this->actualCombustible = $actualCombustible;
        $this->actualBateria = $actualBateria;
    }

    /**
     * @return string|null
     */
    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    /**
     * @return VehicleStatus|null
     */
    public function getVehicleStatus(): ?VehicleStatus
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


}