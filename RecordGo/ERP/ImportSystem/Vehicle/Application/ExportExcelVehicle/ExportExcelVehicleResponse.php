<?php

namespace ImportSystem\Vehicle\Application\ExportExcelVehicle;

class ExportExcelVehicleResponse
{
    /**
     * @var array
     */
    private $vehicleResponse;

    /**
     * @var array
     */
    private $vehicleStatus;

    /**
     * @param array $vehicleResponse
     * @param array $vehicleStatus
     */
    public function __construct(array $vehicleResponse, array $vehicleStatus)
    {
        $this->vehicleResponse = $vehicleResponse;
        $this->vehicleStatus = $vehicleStatus;
    }


    /**
     * @return array
     */
    public function getVehicleResponse(): array
    {
        return $this->vehicleResponse;
    }

    /**
     * @return array
     */
    public function getVehicleStatus(): array
    {
        return $this->vehicleStatus;
    }



}