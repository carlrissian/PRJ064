<?php

namespace ImportSystem\VehicleSeats\Application\SelectList;

class SelectListVehicleSeatsResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListVehicleSeatsResponse constructor.
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
