<?php

namespace ImportSystem\Fleet\Domain;

final class GearBox
{
    private ?int $id;
    private ?string $type;

    /**
     * @param int|null $id
     * @param string|null $type
     */
    public function __construct(?int $id, ?string $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }


    /**
     * @param array $gearBoxArray
     * @return self
     */
    public static function createFromArraySAP(array $gearBoxArray): self
    {
        return new self(
            isset($gearBoxArray['ID']) ? intval($gearBoxArray['ID']) : null,
            $gearBoxArray['GEARBOXTYPE'] ?? null
        );
    }
}
