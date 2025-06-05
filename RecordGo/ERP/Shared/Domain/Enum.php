<?php


namespace Shared\Domain;


use ReflectionClass;

abstract class Enum
{
    protected $value;

    public function __construct($value)
    {
        $this->ensureIsBetweenAcceptedValues($value);

        $this->value = $value;
    }

    abstract protected function throwExceptionForInvalidValue($value);

    public function value()
    {
        return $this->value;
    }

    public function equals(Enum $other): bool
    {
        return $other == $this;
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    private function ensureIsBetweenAcceptedValues($value): void
    {
        $reflected = new ReflectionClass(get_class($this));
        $constants = $reflected->getConstants();
        if (!\in_array($value, $constants, true)) {
            $this->throwExceptionForInvalidValue($value);
        }
    }
}