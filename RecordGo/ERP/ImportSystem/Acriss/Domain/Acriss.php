<?php

namespace ImportSystem\Acriss\Domain;

/**
 * Class Acriss
 * @package ImportSystem\Acriss\Domain
 */
class Acriss
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
     * @var VehicleGroup|null
     */
    protected ?VehicleGroup $vehicleGroup;

    /**
     * Acriss constructor.
     * 
     * @param int $id
     * @param string|null $name
     * @param VehicleGroup|null $vehicleGroup
     */
    public function __construct(int $id, ?string $name, ?VehicleGroup $vehicleGroup)
    {
        $this->id = $id;
        $this->name = $name;
        $this->vehicleGroup = $vehicleGroup;
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
     * @return VehicleGroup|null
     */
    public function getVehicleGroup(): ?VehicleGroup
    {
        return $this->vehicleGroup;
    }


    /**
     * @param integer $id
     * @param string|null $name
     * @param VehicleGroup|null $vehicleGroup
     * @return self
     */
    public static function create(int $id, ?string $name = null, ?VehicleGroup $vehicleGroup = null): self
    {
        return new self($id, $name, $vehicleGroup);
    }


    /**
     * @param array|null $acrissArray
     * @return self
     */
    final public static function createFromArray(?array $acrissArray): self
    {
        return self::create(
            intval($acrissArray['ID']),
            $acrissArray['ACRISSCODE'] ?? null,
            isset($acrissArray['CARGROUP']) ? VehicleGroup::createFromArray($acrissArray['CARGROUP']) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
        ];
    }
}
