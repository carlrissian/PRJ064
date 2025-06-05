<?php

namespace ImportSystem\Fleet\Domain;


use Shared\Utils\DataValidation;

class Branch implements \JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;


    /**
     * @var string|null
     */
    private $name;

    /**
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return array
     */
    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }


    public static function createFromArray(array $arrayBranch):Branch
    {
        $helper = new DataValidation();

        return new self(
            $helper->intOrNull($helper->arrayExistOrNull($arrayBranch,'ID')),
            $helper->arrayExistOrNull($arrayBranch,'LOCATIONNAME')
        );

    }
}