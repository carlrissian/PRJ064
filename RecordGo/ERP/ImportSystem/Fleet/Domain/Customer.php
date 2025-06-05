<?php

namespace ImportSystem\Fleet\Domain;

final class Customer
{

    private ?int $id;
    private ?string $name;
    private ?string $lastName;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $lastName
     */
    public function __construct(?int $id, ?string $name, ?string $lastName)
    {
        $this->id = $id;
        $this->name = $name;
        $this->lastName = $lastName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public static function createFromArraySAP(array $arrayCustomer): Customer
    {
        return new self(
            $arrayCustomer['ID'] ?? null,
            $arrayCustomer['NAMESOCIAL'] ?? null,
            $arrayCustomer['LASTNAME'] ?? null
        );
    }
}