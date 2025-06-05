<?php


namespace ImportSystem\Fleet\Domain;

class Brand
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
     * @param array $brandArray
     * @return self
     */
    public static function createFromArraySAP(array $brandArray): self
    {
        return new self(
            isset($brandArray['ID']) ? intval($brandArray['ID']) : null,
            $brandArray['BRANDNAME'] ?? null
        );
    }
}
