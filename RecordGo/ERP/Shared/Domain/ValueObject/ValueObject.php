<?php


namespace Shared\Domain\ValueObject;


abstract class ValueObject implements \JsonSerializable
{
    abstract public function __toString();

    public function jsonSerialize()
    {
        return $this->__toString();
    }
}