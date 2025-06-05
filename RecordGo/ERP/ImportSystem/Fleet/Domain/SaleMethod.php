<?php

namespace ImportSystem\Fleet\Domain;

class SaleMethod
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
     * @param array $saleMethodArray
     * @return self
     */
    public static function createFromArraySAP(array $saleMethodArray): self
    {
        return new self(
            isset($saleMethodArray['ID'])
                ? intval($saleMethodArray['ID'])
                : (isset($saleMethodArray['PURCHASEMETHODSTATUS']) ? intval($saleMethodArray['PURCHASEMETHODSTATUS']) : null),
            $saleMethodArray['PURCHASEMETHODNAME'] ?? null
        );
    }
}
