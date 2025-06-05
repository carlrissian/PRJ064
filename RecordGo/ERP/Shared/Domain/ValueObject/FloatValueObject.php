<?php


namespace Shared\Domain\ValueObject;


/**
 * Class FloatValueObject2
 * @package Shared\Domain\ValueObject
 */
class FloatValueObject extends ValueObject
{

    const PRECISION = 4;

    /**
     * @var int
     */
    private $value;

    /**
     * FloatValueObject2 constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @param float $value
     * @return FloatValueObject
     */
    public static function create(float $value)
    {
        $intValue = $value * (10 ** self::PRECISION);
        return new self( round($intValue, 0) );
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $precision
     * @return float
     */
    public function getFloatValue(int $precision = self::PRECISION):float
    {
        $floatValue = $this->getValue() / (10 ** self::PRECISION);
        return round($floatValue, $precision);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->getFloatValue());
    }

    /**
     * @param FloatValueObject $obj
     * @return bool
     */
    public function equals(FloatValueObject $obj): bool
    {
        return $this->getValue() === $obj->getValue();
    }

    /**
     * @param FloatValueObject $obj
     * @return bool
     */
    public function greaterThan(FloatValueObject $obj): bool
    {
        return $this->getValue() > $obj->getValue();
    }

    /**
     * @param FloatValueObject $obj
     * @return bool
     */
    public function lessThan(FloatValueObject $obj): bool
    {
        return $this->getValue() < $obj->getValue();
    }
}