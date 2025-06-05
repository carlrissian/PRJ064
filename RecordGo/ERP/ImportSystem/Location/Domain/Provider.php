<?php

namespace ImportSystem\Location\Domain;

class Provider
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $code;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * Provider constructor.
     * 
     * @param int $id
     * @param string|null $code
     * @param string|null $name
     */
    public function __construct(
        int $id,
        ?string $code = null,
        ?string $name = null
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
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
    final public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    final public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param array|null $providerArray
     * @return self
     */
    public static function createFromArray(?array $providerArray): self
    {
        return new self(
            intval($providerArray['ID']),
            (isset($locationArray['PROVIDERSAPID']) && is_numeric($locationArray['PROVIDERSAPID'])) ? intval($locationArray['PROVIDERSAPID']) : null,
            $providerArray['NAMESOCIAL'] ?? null
        );
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'PROVIDERSAPID' => $this->getCode(),
            'NAMESOCIAL' => $this->getName(),
        ];
    }
}
