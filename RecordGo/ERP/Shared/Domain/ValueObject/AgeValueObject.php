<?php


namespace Shared\Domain\ValueObject;


class AgeValueObject extends IntValueObject
{
    /**
     * AgeValueObject constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        parent::__construct($value);
        $this->validate();
    }

    public function minValue($minValue = 0){
        if( $this->value < $minValue){
            throw new \InvalidArgumentException(" El valor no puede ser menor de ".$minValue);
        }
    }

    public function validate(){
        $this->minValue();
    }
}