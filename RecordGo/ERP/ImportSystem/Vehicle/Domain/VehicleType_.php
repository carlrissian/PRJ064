<?php


namespace ImportSystem\Vehicle\Domain;


class VehicleType_ implements \JsonSerializable
{

    /**
     * @var string|null
     */
    private $name;

    /**
     * VehicleType constructor.
     * @param string|null $name
     */
    public function __construct(?string $name){
        $this->name = $name;
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