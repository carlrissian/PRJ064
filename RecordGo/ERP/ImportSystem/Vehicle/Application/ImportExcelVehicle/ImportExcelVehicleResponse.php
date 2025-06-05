<?php

namespace ImportSystem\Vehicle\Application\ImportExcelVehicle;

class ImportExcelVehicleResponse
{

    /**
     * @var array
     */
    private $vehicleList;

    /**
     * @param array $vehicleList
     */
    public function __construct(array $vehicleList)
    {
        $this->vehicleList = $vehicleList;
    }

    /**
     * @return array
     */
    public function getVehicleList(): array
    {
        return $this->vehicleList;
    }


}