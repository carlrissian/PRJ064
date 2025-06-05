<?php

namespace ImportSystem\Fleet\Domain;

final class VehicleSeats
{
    private ?int $id;
    private ?int $value;

    /**
     * @param int|null $id
     * @param int|null $value
     */
    public function __construct(?int $id, ?int $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }


    /**
     * @param array $vehicleSeatsArray
     * @return self
     */
    public static function createFromArraySAP(array $vehicleSeatsArray): self
    {
        return new self(
            isset($vehicleSeatsArray['ID']) ? intval($vehicleSeatsArray['ID']) : null,
            isset($vehicleSeatsArray['CARSEATSVALUE']) ? intval($vehicleSeatsArray['CARSEATSVALUE']) : null
        );
    }
}
