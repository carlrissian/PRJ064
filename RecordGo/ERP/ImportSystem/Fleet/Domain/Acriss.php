<?php

namespace ImportSystem\Fleet\Domain;

class Acriss
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
     * @param array $acrissArray
     * @return self
     */
    public static function createFromArraySAP(array $acrissArray): self
    {
        return new self(
            isset($acrissArray['ID']) ? intval($acrissArray['ID']) : null,
            $acrissArray['ACRISSCODE'] ?? null
        );
    }
}
