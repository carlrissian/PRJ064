<?php

namespace ImportSystem\Location\Domain;

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
     * State constructor.
     * 
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
     * @param array|null $stateArray
     * @return self
     */
    public static function createFromArray(?array $stateArray): self
    {
        return new self(
            intval($stateArray['ID']),
            $stateArray['STATENAME'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'STATENAME' => $this->getName(),
        ];
    }
}
