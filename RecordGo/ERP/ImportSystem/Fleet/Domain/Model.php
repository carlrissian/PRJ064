<?php


namespace ImportSystem\Fleet\Domain;

class Model
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
     * @param array $modelArray
     * @return self
     */
    public static function createFromArraySAP(array $modelArray): self
    {
        return new self(
            isset($modelArray['ID']) ? intval($modelArray['ID']) : null,
            $modelArray['MODELNAME'] ?? null
        );
    }
}
