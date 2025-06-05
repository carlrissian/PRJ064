<?php

namespace ImportSystem\PurchaseType\Domain;

class PurchaseType
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
     * PurchaseType constructor.
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
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }


    /**
     * @param array|null $purchaseTypeArray
     * @return self
     */
    public static function createFromArray(?array $purchaseTypeArray): self
    {
        return new self(
            intval($purchaseTypeArray['ID']),
            $purchaseTypeArray['PURCHASETYPENAME'] ?? null
        );
    }
}
