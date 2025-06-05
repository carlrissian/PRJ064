<?php


namespace Shared\Domain\Criteria;


class Filter
{
    /**
     * @var string
     */
    private $field;
    /**
     * @var FilterOperator
     */
    private $operator;
    /**
     * @var string|int|array
     */
    private $value;

    /**
     * Filter constructor.
     * @param string $field
     * @param FilterOperator $operator
     * @param string|int|array $value
     */
    public function __construct(string $field, FilterOperator $operator, $value)
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @return FilterOperator
     */
    public function getOperator(): FilterOperator
    {
        return $this->operator;
    }

    /**
     * @return array|int|string
     */
    public function getValue()
    {
        return $this->value;
    }
}