<?php

namespace ImportSystem\Fleet\Domain;

class Location
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
     * @param array $locationArray
     * @return self
     */
    public static function createFromArraySAP(array $locationArray): self
    {
        return new self(
            isset($locationArray['ID']) ? intval($locationArray['ID']) : null,
            $locationArray['LOCATIONNAME'] ?? null
        );
    }
}
