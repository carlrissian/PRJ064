<?php

namespace ImportSystem\Location\Domain;

class Area
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
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null
    ) {
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
     * @param array|null $areaArray
     * @return self
     */
    public static function createFromArray(?array $areaArray): self
    {
        return new self(
            intval($areaArray['ID']),
            $areaArray['AREANAME'] ?? null
        );
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'AREANAME' => $this->getName(),
        ];
    }
}
