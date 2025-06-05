<?php

namespace ImportSystem\Fleet\Domain;

final class VehicleGroup
{
    private ?int $id;
    private ?string $name;

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array $vehicleGroupArray
     * @return self
     */
    public static function createFromArraySAP(array $vehicleGroupArray): self
    {
        return new self(
            isset($vehicleGroupArray['ID']) ? intval($vehicleGroupArray['ID']) : null,
            $vehicleGroupArray['VEHICLEGROUPNAME'] ?? null
        );
    }
}
