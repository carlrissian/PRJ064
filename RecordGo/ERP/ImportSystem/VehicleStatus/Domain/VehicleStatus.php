<?php

namespace ImportSystem\VehicleStatus\Domain;

class VehicleStatus
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * VehicleStatus constructor.
     * 
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
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
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param array|null $vehicleStatusArray
     * @return self
     */
    public static function createFromArray(?array $vehicleStatusArray): self
    {
        return new self(
            intval($vehicleStatusArray['ID']),
            $vehicleStatusArray['STATUSNAME'] ?? $vehicleStatusArray['NAME'] ?? null
        );
    }
}
