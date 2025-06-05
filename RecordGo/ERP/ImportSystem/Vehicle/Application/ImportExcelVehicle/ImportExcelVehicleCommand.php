<?php

namespace ImportSystem\Vehicle\Application\ImportExcelVehicle;

use ImportSystem\Vehicle\Domain\Vehicle;

class ImportExcelVehicleCommand
{
    /**
     * @var array
     */

    private $array;

    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->array;
    }


}