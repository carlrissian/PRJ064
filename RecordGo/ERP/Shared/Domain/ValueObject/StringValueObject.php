<?php

namespace Shared\Domain\ValueObject;

/**
 * Class StringValueObject
 * @package Shared\Domain\ValueObject
 */
abstract class StringValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * StringValueObject constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     * @deprecated Utilizar la funcion getValue en vez de esta. dejo esta funcion para mantener compatibilidad
     */
    public function value(): string
    {
        return $this->getValue();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value();
    }
}
