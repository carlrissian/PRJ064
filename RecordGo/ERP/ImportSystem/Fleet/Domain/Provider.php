<?php

namespace ImportSystem\Fleet\Domain;

class Provider
{
    private ?int $id;
    private ?string $name;
    private ?string $providerSAPId;
    private ?string $customerSAPId;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $providerSAPId
     * @param string|null $customerSAPId
     */
    public function __construct(?int $id, ?string $name, ?string $providerSAPId, ?string $customerSAPId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->providerSAPId = $providerSAPId;
        $this->customerSAPId = $customerSAPId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getProviderSAPId(): ?string
    {
        return $this->providerSAPId;
    }

    public function getCustomerSAPId(): ?string
    {
        return $this->customerSAPId;
    }


    /**
     * @param array $providerArray
     * @return self
     */
    public static function createFromArraySAP(array $providerArray): self
    {
        return new self(
            isset($providerArray['ID']) ? intval($providerArray['ID']) : null,
            $providerArray['NAMESOCIAL'] ?? null,
            $providerArray['PROVIDERSAPID'] ?? null,
            $providerArray['CUSTOMERSAPID'] ?? null
        );
    }
}
