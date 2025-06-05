<?php

namespace Shared\Domain;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string|null
     */
    private $name;

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
     * @param array $userArray
     * @return User
     */
    public static function createFromArray(array $userArray): self
    {
        return new self(
            intval($userArray['ID']),
            $userArray['USERALIAS'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'USERALIAS' => $this->getName()
        ];
    }
}
