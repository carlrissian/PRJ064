<?php


namespace Shared\Domain\Criteria;


use InvalidArgumentException;
use Shared\Domain\Enum;

class FilterOperator extends Enum
{
    public const EQUAL                  = '=';
    public const NOT_EQUAL              = '<>';
    public const GREATER_THAN           = '>';
    public const GREATER_EQUAL_THAN     = '>=';
    public const LESS_THAN              = '<';
    public const LESS_EQUAL_THAN        = '<=';
    public const CONTAINS               = 'CONTAINS';
    public const IN                     = 'IN';
    public const NOT_IN                 = 'NOT IN';

    protected function throwExceptionForInvalidValue($value)
    {
        throw new InvalidArgumentException();
    }
}