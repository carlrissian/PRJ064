<?php

namespace ImportSystem\Acriss\Domain;

/**
 * Class VehicleGroup
 * @package ImportSystem\Acriss\Domain
 */
class VehicleGroup
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * VehicleGroup constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int
     */
    final public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param integer $id
     * @param string|null $name
     * @return self
     */
    public static function create(int $id, ?string $name = null): self
    {
        return new self($id, $name);
    }

    /**
     * @param array|null $vehicleGroupArray
     * @return self
     */
    final public static function createFromArray(?array $vehicleGroupArray): self
    {
        return self::create(
            intval($vehicleGroupArray['ID']),
            $vehicleGroupArray['VEHICLEGROUPNAME'] ?? null
        );
    }
}
