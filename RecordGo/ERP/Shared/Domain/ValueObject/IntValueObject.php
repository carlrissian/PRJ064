<?php

namespace Shared\Domain\ValueObject;

/**
 * Class IntValueObject
 * @package Shared\Domain\ValueObject
 */
abstract class IntValueObject
{
    /**
     * @var int
     */
    protected $value;

    /**
     * IntValueObject constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     * @deprecated Utilizar la funcion getValue en vez de esta. dejo esta funcion para mantener compatibilidad
     */
    public function value(): int
    {
        return $this->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getValue();
    }
}
