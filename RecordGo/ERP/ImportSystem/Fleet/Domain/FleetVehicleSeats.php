<?php

namespace ImportSystem\Fleet\Domain;

use Shared\Utils\DataValidation;

class FleetVehicleSeats
{

    /**
     * @var int|null
     */
    private $id;

    /**
     * @var int|null
     */
    private $carSeatsValue;

    /**
     * @param int|null $id
     * @param int|null $carSeatsValue
     */
    public function __construct(?int $id, ?int $carSeatsValue)
    {
        $this->id = $id;
        $this->carSeatsValue = $carSeatsValue;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCarSeatsValue(): ?int
    {
        return $this->carSeatsValue;
    }

    public static function createFromArray(array $arrayFleetVehicleSeats):FleetVehicleSeats
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($arrayFleetVehicleSeats,'ID')),
            $helper->arrayExistOrNull($arrayFleetVehicleSeats,'CARSEATSVALUE')
        );

    }


}