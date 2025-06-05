<?php

namespace ImportSystem\Location\Domain;

class LocationType
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
     * LocationType constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name = null)
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $locationTypeArray
     * @return self
     */
    public static function createFromArray(?array $locationTypeArray): self
    {
        return new self(
            intval($locationTypeArray['ID']),
            $locationTypeArray['LOCATIONTYPENAME']
        );
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'LOCATIONTYPENAME' => $this->getName()
        ];
    }
}
