<?php

namespace ImportSystem\VehicleSeats\Domain;

class VehicleSeats
{
    /** 
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $value;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * VehicleSeats constructor.
     * 
     * @param int $id
     * @param int $value
     * @param string|null $description
     */
    public function __construct(int $id, int $value, ?string $description)
    {
        $this->id = $id;
        $this->value = $value;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


    /**
     * @param integer $id
     * @param string $value
     * @return self
     */
    public static function create(int $id, string $value, ?string $description = null): self
    {
        return new self($id, $value, $description);
    }


    /**
     * @param array|null $vehicleSeatsArray
     * @return self
     */
    public static function createFromArray(?array $vehicleSeatsArray): self
    {
        return new self(
            intval($vehicleSeatsArray['ID']),
            isset($vehicleSeatsArray['CARSEATSVALUE']) ? intval($vehicleSeatsArray['CARSEATSVALUE']) : null,
            $vehicleSeatsArray['CARSEATSDESCRIPTION'] ?? null
        );
    }
}
