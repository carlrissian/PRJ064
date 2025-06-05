<?php

namespace ImportSystem\Brand\Domain;

class Brand
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * Brand constructor.
     * 
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
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
     * @param array|null $brandArray
     * @return self
     */
    public static function createFromArray(?array $brandArray): self
    {
        return new self(
            intval($brandArray['ID']),
            $brandArray['BRANDNAME'] ?? null
        );
    }
}
