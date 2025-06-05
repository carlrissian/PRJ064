<?php

namespace ImportSystem\VehicleStatus\Application\SelectList;

class SelectListVehicleStatusResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListVehicleStatusResponse constructor.
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
