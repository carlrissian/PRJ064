<?php

namespace ImportSystem\SaleMethod\Domain;

class SaleMethod
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
     * SaleMethod constructor.
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
     * @param array $saleMethodArray
     * @return self
     */
    public static function createFromArray(array $saleMethodArray): self
    {
        return new self(
            intval($saleMethodArray['ID']),
            $saleMethodArray['NAME'] ?? null
        );
    }
}
