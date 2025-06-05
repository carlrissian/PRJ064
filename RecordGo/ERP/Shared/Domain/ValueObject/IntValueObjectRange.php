<?php


namespace Shared\Domain\ValueObject;


class IntValueObjectRange
{
    /**
     * @var IntValueObject
     */
    protected $valueMin;
    /**
     * @var IntValueObject
     */
    protected $valueMax;


    /**
     * IntValueObjectRange constructor.
     * @param IntValueObject $valueMin
     * @param IntValueObject $valueMax
     */
    public function __construct(IntValueObject $valueMin, IntValueObject $valueMax)
    {
        $this->valueMin = $valueMin;
        $this->valueMax = $valueMax;
    }

    /**
     * @return IntValueObject
     */
    public function getValueMin(): IntValueObject
    {
        return $this->valueMin;
    }

    /**
     * @return IntValueObject
     */
    public function getValueMax(): IntValueObject
    {
        return $this->valueMax;
    }

}