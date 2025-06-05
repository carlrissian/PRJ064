<?php

namespace ImportSystem\Trim\Domain;

class Trim
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
     * @var Model|null
     */
    private ?Model $model;

    /**
     * @var Brand|null
     */
    private ?Brand $brand;

    /**
     * Trim constructor.
     * 
     * @param int $id
     * @param string $name
     * @param Model|null $model
     * @param Brand|null $brand
     */
    public function __construct(int $id, string $name, ?Model $model, ?Brand $brand)
    {
        $this->id = $id;
        $this->name = $name;
        $this->model = $model;
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
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }


    /**
     * @param integer $id
     * @param string $name
     * @param Model|null $model
     * @param Brand|null $brand
     * @return self
     */
    public static function create(int $id, string $name, ?Model $model = null, ?Brand $brand = null): self
    {
        $trim = new self(
            $id,
            $name,
            $model,
            $brand
        );
        $trim->validate();
        return $trim;
    }

    private function validate(): void
    {
        // if (empty($this->getName())) {
        //     throw new \InvalidArgumentException('Name is required');
        // }
    }


    /**
     * @param array|null $trimArray
     * @return self
     */
    public static function createFromArray(?array $trimArray): self
    {
        return self::create(
            intval($trimArray['ID']),
            $trimArray['TRIMNAME'] ?? null,
            isset($trimArray['MODEL']) ? Model::createFromArray($trimArray['MODEL']) : null,
            isset($trimArray['BRAND']) ? Brand::createFromArray($trimArray['BRAND']) : null
        );
    }
}
