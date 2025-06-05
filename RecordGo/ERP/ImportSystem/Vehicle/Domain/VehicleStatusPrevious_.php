<?php


namespace ImportSystem\Vehicle\Domain;


class VehicleStatusPrevious_ implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string|null
     */
    private $name;

    /**
     * VehicleStatus constructor.
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name){
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}