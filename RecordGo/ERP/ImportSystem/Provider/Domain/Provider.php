<?php

namespace ImportSystem\Provider\Domain;

class Provider
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
    private ?string $providerSAPId;

    /**
     * @var string|null
     */
    private ?string $customerSAPId;

    /**
     * @var string|null
     */
    private ?string $vatNumber;

    /**
     * @var string|null
     */
    private ?string $city;

    /**
     * @var State|null
     */
    private ?State $state;

    /**
     * @var ProviderType|null
     */
    private ?ProviderType $ProviderType;


    /**
     * Provider constructor.
     * @param int|null $id
     * @param string|null $name
     * @param string|null $providerSAPId
     * @param string|null $customerSAPId
     * @param string|null $vatNumber
     * @param string|null $city
     * @param State|null $state
     * @param ProviderType|null $ProviderType
     */
    public function __construct(
        ?int $id,
        ?string $name,
        ?string $providerSAPId,
        ?string $customerSAPId,
        ?string $vatNumber,
        ?string $city,
        ?State $state,
        ?ProviderType $ProviderType
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->providerSAPId = $providerSAPId;
        $this->customerSAPId = $customerSAPId;
        $this->vatNumber = $vatNumber;
        $this->city = $city;
        $this->state = $state;
        $this->ProviderType = $ProviderType;
    }


    /**
     * @return int|null
     */
    final public function getId(): ?int
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
    public function getProviderSAPId(): ?string
    {
        return $this->providerSAPId;
    }

    /**
     * @return string|null
     */
    public function getCustomerSAPId(): ?string
    {
        return $this->customerSAPId;
    }

    /**
     * @return string|null
     */
    final public function getVatNumber(): ?string
    {
        return $this->vatNumber;
    }

    /**
     * @return string|null
     */
    final public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return State|null
     */
    final public function getState(): ?State
    {
        return $this->state;
    }

    /**
     * @return ProviderType|null
     */
    final public function getProviderType(): ?ProviderType
    {
        return $this->ProviderType;
    }

    /**
     * @param integer|null $id
     * @param string|null $name
     * @param string|null $providerSAPId
     * @param string|null $customerSAPId
     * @param string|null $vatNumber
     * @param string|null $city
     * @param State|null $state
     * @param ProviderType|null $ProviderType
     * @return self
     */
    public static function create(
        ?int $id,
        ?string $name,
        ?string $providerSAPId,
        ?string $customerSAPId,
        ?string $vatNumber,
        ?string $city,
        ?State $state,
        ?ProviderType $ProviderType
    ): self {
        return new self(
            $id,
            $name,
            $providerSAPId,
            $customerSAPId,
            $vatNumber,
            $city,
            $state,
            $ProviderType
        );
    }


    /**
     * @param array|null $providerArray
     * @return self
     */
    public static function createFromArray(?array $providerArray): self
    {
        return self::create(
            intval($providerArray['ID']),
            $providerArray['NAMESOCIAL'] ?? null,
            $providerArray['PROVIDERSAPID'] ?? null,
            $providerArray['CUSTOMERSAPID'] ?? null,
            $providerArray['VATNUM'] ?? null,
            $providerArray['CITY'] ?? null,
            isset($providerArray['PROVINCE']) ? State::createFromArray($providerArray['PROVINCE']) : null,
            isset($providerArray['SUPPLIERTYPE']) ? ProviderType::createFromArray($providerArray['SUPPLIERTYPE']) : null
        );
    }

    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'NAMESOCIAL' => $this->getName(),
            'PROVIDERSAPID' => $this->getProviderSAPId(),
            'CUSTOMERSAPID' => $this->getCustomerSAPId(),
            'VATNUM' => $this->getVatNumber(),
            'CITY' => $this->getCity(),
            'PROVINCE' => ($this->getState() !== null) ? $this->getState()->toArray() : null,
            'SUPPLIERTYPE' => ($this->getProviderType() !== null) ? $this->getProviderType()->toArray() : null,
        ];
    }
}
