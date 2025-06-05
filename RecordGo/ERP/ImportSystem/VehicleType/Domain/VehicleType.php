<?php

namespace ImportSystem\VehicleType\Domain;

class VehicleType
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
     * VehicleType constructor.
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
     * @param array|null $vehicleTypeArray
     * @return self
     */
    public static function createFromArray(?array $vehicleTypeArray): self
    {
        return new self(
            intval($vehicleTypeArray['ID']),
            $vehicleTypeArray['CARTYPENAME'] ?? null
        );
    }
}
