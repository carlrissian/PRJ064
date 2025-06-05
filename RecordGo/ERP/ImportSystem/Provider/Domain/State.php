<?php

namespace ImportSystem\Provider\Domain;

class State
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
    private ?string $iso;

    /**
     * @var int|null
     */
    private ?int $countryId;

    /**
     * State constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $name = null,
        ?string $iso = null,
        ?int $countryId = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->iso = $iso;
        $this->countryId = $countryId;
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
    public function getISO(): ?string
    {
        return $this->iso;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->countryId;
    }


    /**
     * @param array|null $stateArray
     * @return self
     */
    public static function createFromArray(?array $stateArray): self
    {
        return new self(
            intval($stateArray['ID']),
            $stateArray['STATENAME'] ?? null,
            $stateArray['ISOCODE'] ?? null,
            isset($stateArray['COUNTRYID']) ? intval($stateArray['COUNTRYID']) : null
        );
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'STATENAME' => $this->getName(),
            'STATEISOCODE' => $this->getISO(),
            'COUNTRYID' => $this->getCountryId(),
        ];
    }
}
