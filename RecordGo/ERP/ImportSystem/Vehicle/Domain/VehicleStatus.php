<?php

namespace ImportSystem\Vehicle\Domain;

class VehicleStatus
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
     * @param array $vehicleStatusArray
     * @return self
     */
    public static function createFromArraySAP(array $vehicleStatusArray): self
    {
        return new self(
            isset($vehicleStatusArray['ID']) ? intval($vehicleStatusArray['ID']) : null,
            $vehicleStatusArray['STATUSNAME'] ?? null,
        );
    }
}
