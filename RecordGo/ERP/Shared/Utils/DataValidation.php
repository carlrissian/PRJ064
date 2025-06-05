<?php

namespace Shared\Utils;

use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Domain\ValueObject\DateValueObject;
use Shared\Domain\ValueObject\TimeValueObject;
use Shared\Utils\Utils;

class DataValidation
{
    final public function intOrNull(?string $var): ?int
    {
        $ret = null;
        if ($var !== null) {
            $ret = (is_numeric($var))?intval($var):null;
        }
        return $ret;
    }
    final public function floatOrNull(?string $var): ?float
    {
        $ret = null;
        if ($var !== null) {
            $ret = (is_numeric($var))?floatval($var):null;
        }
        return $ret;
    }

    final public function dateValueOrNull(?string $var): ?DateValueObject
    {
        $ret = null;
        if ($var !== null) {
            $ret = ($var)?new DateValueObject(Utils::convertOdataDateToDateTime($var)) : null;
        }
        return $ret;
    }
    final public function dateTimeValueOrNull(?string $var): ?DateTimeValueObject
    {
        $ret = null;
        if ($var !== null) {
            $ret = ($var)?new DateTimeValueObject(Utils::convertOdataDateToDateTime($var)) : null;
        }
        return $ret;
    }

    final public function arrayExistOrNull(?array $var, string $key): ?string
    {
        return (isset($var[$key])) ? $var[$key] : null;
    }

    final public function timeValueOrNull(?string $var): ?TimeValueObject
    {
        $ret = null;
        if (stripos($var, 'PT')===0) {
            $ret = ($var !== null) ? new TimeValueObject(Utils::convertOdataTimeToMinutes($var)) : null;
        }
        return $ret;
    }
    final public function boolOrNull(?string $var): ?bool
    {
        $ret = null;
        if ($var !== null) {
            $ret = boolval($var);
        }
        return $ret;
    }
}