<?php

namespace ImportSystem\Vehicle\Application\VehicleUpdate;

class VehicleUpdateResponse
{
    /**
     * @var mixed $value
     */

    private $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }


}