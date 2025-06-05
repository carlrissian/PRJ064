<?php

namespace ImportSystem\Fleet\Domain;

final class Trim
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
     * @param array $trimArray
     * @return self
     */
    public static function createFromArraySAP(array $trimArray): self
    {
        return new self(
            isset($trimArray['ID']) ? intval($trimArray['ID']) : null,
            $trimArray['TRIMNAME'] ?? null
        );
    }
}
