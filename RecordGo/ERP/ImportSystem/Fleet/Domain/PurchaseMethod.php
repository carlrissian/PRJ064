<?php

namespace ImportSystem\Fleet\Domain;

class PurchaseMethod
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
     * @param array $purchaseMethodArray
     * @return self
     */
    public static function createFromArraySAP(array $purchaseMethodArray): self
    {
        return new self(
            isset($purchaseMethodArray['ID'])
                ? intval($purchaseMethodArray['ID'])
                : (isset($purchaseMethodArray['PURCHASEMETHODSTATUS']) ? intval($purchaseMethodArray['PURCHASEMETHODSTATUS']) : null),
            $purchaseMethodArray['PURCHASEMETHODNAME'] ?? null
        );
    }
}
