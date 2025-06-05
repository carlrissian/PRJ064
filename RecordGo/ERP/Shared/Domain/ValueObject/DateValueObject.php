<?php

namespace Shared\Domain\ValueObject;

class DateValueObject extends AbstractDateTimeValueObject
{
    protected const ARRAY_FORMAT_VALID = [
        self::DATE,
        self::DATE_SQL
    ];

    /**
     * @return string
     */
    public function __toString(): string
    {
        $dateFormat = func_num_args() > 0 ? func_get_arg(0) : self::DATE;
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
    public function format(string $dateFormat = self::DATE): string
    {
        return $this->__toString($dateFormat);
    }
}