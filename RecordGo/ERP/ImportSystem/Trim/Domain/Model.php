<?php

namespace ImportSystem\Trim\Domain;

class Model
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
     * @var Brand|null
     */
    private ?Brand $brand;

    /**
     * Model constructor.
     * 
     * @param int $id
     * @param string $name
     * @param Brand|null $brand
     */
    public function __construct(int $id, string $name, ?Brand $brand = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->brand = $brand;
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
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }


    /**
     * @param array|null $modelArray
     * @return Model
     */
    public static function createFromArray(?array $modelArray): Model
    {
        return new self(
            intval($modelArray['ID']),
            $modelArray['MODELNAME'] ?? null,
            isset($modelArray['Brand']) ? Brand::createFromArray($modelArray['Brand']) : null
        );
    }
}
