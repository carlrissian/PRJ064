<?php

namespace Shared\Domain\ValueObject;

abstract class AbstractDateTimeValueObject extends ValueObject
{
    public const DATE_HOUR_MINUTES_SECOND = 'd/m/Y H:i:s';
    public const DATE_HOUR_MINUTES = 'd/m/Y H:i';
    public const DATE = 'd/m/Y';
    public const DATE_SQL = 'Y-m-d';
    public const HOUR = 'H:i';
    public const MONTH = 'm';

    /**
     * @var \DateTime
     */
    protected $value;

    /**
     * DateTime constructor.
     * @param \DateTime $value
     */
    public function __construct(\DateTime $value)
    {
        $this->value = $value;
    }

    /**
     * @param \DateTime $dateTime
     * @return static
     * @deprecated
     */
    public static function createFromDateTime(\DateTime $dateTime)
    {
        return new static($dateTime);
    }

    /**
     * @return \DateTime
     */
    public function getValue(): \DateTime
    {
        return $this->value;
    }

    /**
     * @return \DateTime
     * @deprecated
     */
    public function get(): \DateTime
    {
        return $this->getValue();
    }

    /**
     * @return string
     */
    abstract public function __toString(): string;

    /**
     * @param string $dateFormat
     * @return string
     * @deprecated
     */
    abstract public function format(string $dateFormat): string;

    /**
     * @param string $date
     * @return static|null
     */
    public static function createFromString(string $date)
    {
        $dateTime = false;
        for($i=0;$i<sizeof(static::ARRAY_FORMAT_VALID) && !$dateTime;$i++){
            $dateTime = \DateTime::createFromFormat('!' . static::ARRAY_FORMAT_VALID[$i], $date);
        }
        if( !$dateTime ) throw new \InvalidArgumentException('Date format is not valid');
//        $aux = explode('/', $date);
//        dd($aux);
//        if( !checkdate($aux[0], $aux[1], $aux[2]) ) throw new \InvalidArgumentException('Date format is not valid');

        return new static($dateTime);
    }

    /**
     * @param DateTimeValueObject $obj
     * @return bool
     */
    public function equals(DateTimeValueObject $obj): bool
    {
        return $this->getValue() == $obj->getValue();
    }

    /**
     * @param DateTimeValueObject $obj
     * @return bool
     */
    public function greaterThan(DateTimeValueObject $obj): bool
    {
        return $this->getValue() > $obj->getValue();
    }

    /**
     * @param DateTimeValueObject $obj
     * @return bool
     */
    public function lessThan(DateTimeValueObject $obj): bool
    {
        return $this->getValue() < $obj->getValue();
    }
}