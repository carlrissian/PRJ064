<?php

namespace Shared\Domain\ValueObject;


/**
 * Class DateTimeValueObject
 * @package Shared\Domain\ValueObject
 */
class DateTimeValueObject extends AbstractDateTimeValueObject
{
    protected const ARRAY_FORMAT_VALID = [
        self::DATE_HOUR_MINUTES_SECOND,
        self::DATE_HOUR_MINUTES,
        self::DATE,
        self::DATE_SQL,
        self::HOUR,
        self::MONTH
    ];

    /**
     * @return string
     */
    public function __toString(): string
    {
        $dateFormat = func_num_args() > 0 ? func_get_arg(0) : self::DATE_HOUR_MINUTES_SECOND;
        if (!in_array($dateFormat, self::ARRAY_FORMAT_VALID, true)) {
            throw new \InvalidArgumentException('Format not allowed');
        }
        return $this->value->format($dateFormat);
    }

    /**
     * @param string $dateFormat
     * @return string
     * @deprecated
     */
    public function format(string $dateFormat = self::DATE_HOUR_MINUTES_SECOND): string
    {
        return $this->__toString($dateFormat);
    }
}