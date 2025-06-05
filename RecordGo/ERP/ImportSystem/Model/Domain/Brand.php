<?php

namespace ImportSystem\Model\Domain;

class Brand
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
     * Brand constructor.
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
     * @param array|null $brandArray
     * @return Brand
     */
    public static function createFromArray(?array $brandArray): Brand
    {
        return new self(
            intval($brandArray['ID']),
            $brandArray['BRANDNAME'] ?? null
        );
    }
}
