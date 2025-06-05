<?php

namespace ImportSystem\GearBox\Domain;

class GearBox
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private string $name;

    /**
     * @var string|null
     */
    private ?string $acrissLetter;

    /**
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
     * @return string|null
     */
    final public function getAcrissLetter(): ?string
    {
        return $this->acrissLetter;
    }


    /**
     * @param array|null $gearBoxArray
     * @return GearBox
     */
    public static function createFromArray(?array $gearBoxArray): GearBox
    {
        return new self(
            intval($gearBoxArray['ID']),
            $gearBoxArray['GEARBOXTYPE'] ?? null,
            $gearBoxArray['ACRISSTRANS'] ?? null
        );
    }
}
