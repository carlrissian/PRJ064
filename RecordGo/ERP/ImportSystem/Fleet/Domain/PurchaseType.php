<?php

namespace ImportSystem\Fleet\Domain;

class PurchaseType
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
     * @param array $purchaseTypeArray
     * @return self
     */
    public static function createFromArraySAP(array $purchaseTypeArray): self
    {
        return new self(
            isset($purchaseTypeArray['ID'])
                ? intval($purchaseTypeArray['ID'])
                : (isset($purchaseTypeArray['STATUS']) ? intval($purchaseTypeArray['STATUS']) : null),
            $purchaseTypeArray['PURCHASETYPENAME'] ?? null
        );
    }
}
