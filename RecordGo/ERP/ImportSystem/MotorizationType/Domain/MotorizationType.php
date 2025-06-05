<?php

namespace ImportSystem\MotorizationType\Domain;

class MotorizationType
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
     * @var string|null
     */
    private ?string $acrissLetter;

    /**
     * MotorizationType constructor.
     * 
     * @param int $id
     * @param string|null $name
     * @param string|null $acrissLetter
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $acrissLetter = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->acrissLetter = $acrissLetter;
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
     * @return string|null
     */
    public function getAcrissLetter(): ?string
    {
        return $this->acrissLetter;
    }


    /**
     * @param array|null $motorizationTypeArray
     * @return self
     */
    public static function createFromArray(?array $motorizationTypeArray): self
    {
        return new self(
            intval($motorizationTypeArray['ID']),
            $motorizationTypeArray['MOTORTYPENAME'] ?? null,
            $motorizationTypeArray['ACRISSMOTOR'] ?? null
        );
    }
}
