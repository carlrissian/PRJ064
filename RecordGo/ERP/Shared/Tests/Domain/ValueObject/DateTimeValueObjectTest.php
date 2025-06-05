<?php


namespace Shared\Tests\Domain\ValueObject;


use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\DateTimeValueObject;

class DateTimeValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnDateTimeValueObject()
    {
        $obj = new DateTimeValueObject(new \DateTime());
        $this->assertInstanceOf(DateTimeValueObject::class, $obj);
    }

    /**
     * @test
     */
    public function shouldReturnDateTimeValueObjectFromString()
    {
        $obj = DateTimeValueObject::createFromString('14/02/2020');
        $this->assertInstanceOf(DateTimeValueObject::class, $obj);
    }

    /**
     * @test
     */
    public function shouldReturnDateTime()
    {
        $obj = new DateTimeValueObject(new \DateTime());
        $this->assertInstanceOf(\DateTime::class, $obj->getValue());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenStringFormatIsNotValid()
    {
        $this->expectException(\InvalidArgumentException::class);
        DateTimeValueObject::createFromString('14-02-2020');
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfDatesAreEqual()
    {
        $date1 = DateTimeValueObject::createFromString('14/02/2020 11:00');
        $date2 = DateTimeValueObject::createFromString('14/02/2020 11:00');

        $equals = $date1->equals($date2);
        $this->assertTrue($equals);
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfDatesAreNotEqual()
    {
        $date1 = DateTimeValueObject::createFromString('14/02/2020 11:00');
        $date2 = DateTimeValueObject::createFromString('14/02/2020 12:00');

        $equals = $date1->equals($date2);
        $this->assertFalse($equals);
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfDateIsGreaterThanOther()
    {
        $date1 = DateTimeValueObject::createFromString('15/02/2020 11:00');
        $date2 = DateTimeValueObject::createFromString('14/02/2020 11:00');

        $equals = $date1->greaterThan($date2);
        $this->assertTrue($equals);
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfDateIsNotGreaterThanOther()
    {
        $date1 = DateTimeValueObject::createFromString('14/02/2020 11:00');
        $date2 = DateTimeValueObject::createFromString('14/02/2020 11:00');

        $equals = $date1->greaterThan($date2);
        $this->assertFalse($equals);
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfDateIsLessThanOther()
    {
        $date1 = DateTimeValueObject::createFromString('13/02/2020 11:00');
        $date2 = DateTimeValueObject::createFromString('14/02/2020 11:00');

        $equals = $date1->lessThan($date2);
        $this->assertTrue($equals);
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfDateIsNotLessThanOther()
    {
        $date1 = DateTimeValueObject::createFromString('14/02/2020 11:00');
        $date2 = DateTimeValueObject::createFromString('14/02/2020 11:00');

        $equals = $date1->lessThan($date2);
        $this->assertFalse($equals);
    }
}