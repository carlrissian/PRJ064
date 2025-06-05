<?php

namespace ImportSystem\VehicleType\Application\SelectList;

class SelectListVehicleTypeResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListVehicleTypeResponse constructor.
     *
     * @param array $selectList
     */
    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
