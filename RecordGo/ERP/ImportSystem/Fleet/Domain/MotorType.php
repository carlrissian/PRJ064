<?php

namespace ImportSystem\Fleet\Domain;

final class MotorType
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
     * @param array $motorTypeArray
     * @return self
     */
    public static function createFromArraySAP(array $motorTypeArray): self
    {
        return new self(
            isset($motorTypeArray['ID']) ? intval($motorTypeArray['ID']) : null,
            $motorTypeArray['MOTORTYPENAME'] ?? null
        );
    }
}
