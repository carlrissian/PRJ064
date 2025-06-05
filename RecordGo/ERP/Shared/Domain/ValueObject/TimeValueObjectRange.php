<?php


namespace Shared\Domain\ValueObject;


class TimeValueObjectRange
{
    /**
     * @var TimeValueObject
     */
    private $valueMin;
    /**
     * @var TimeValueObject
     */
    private $valueMax;

    /**
     * pickup constructor.
     * @param TimeValueObject $valueMin
     * @param TimeValueObject $valueMax
     */
    public function __construct(TimeValueObject $valueMin, TimeValueObject $valueMax)
    {

        $this->valueMin = $valueMin;
        $this->valueMax = $valueMax;
    }

    /**
     * @return TimeValueObject
     */
    public function getValueMin(): TimeValueObject
    {
        return $this->valueMin;
    }

    /**
     * @return TimeValueObject
     */
    public function getValueMax(): TimeValueObject
    {
        return $this->valueMax;
    }

}