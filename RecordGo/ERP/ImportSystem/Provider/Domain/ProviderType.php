<?php

namespace ImportSystem\Provider\Domain;

class ProviderType
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
     * ProviderType constructor.
     * 
     * @param int $id
     * @param string|null $name
     */
    public function __construct(int $id, ?string $name = null)
    {
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * @param array|null $providerTypeArray
     * @return self
     */
    public static function createFromArray(?array $providerTypeArray): self
    {
        return new self(
            intval($providerTypeArray['ID']),
            $providerTypeArray['PROVIDERCATNAME'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PROVIDERCATNAME' => $this->getName(),
        ];
    }
}
