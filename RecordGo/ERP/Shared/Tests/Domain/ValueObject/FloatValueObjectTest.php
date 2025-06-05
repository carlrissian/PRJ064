<?php


namespace Shared\Tests\Domain\ValueObject;


use PHPUnit\Framework\TestCase;
use Shared\Domain\ValueObject\FloatValueObject;

class FloatValueObjectTest extends TestCase
{
    /**
     * @test
     */
    public function shouldReturnFloatValueObject()
    {
        $obj = FloatValueObject::create(1.5);
        $this->assertInstanceOf(FloatValueObject::class, $obj);
    }

    /**
     * @test
     */
    public function shouldReturnFloatValueObjectFromInt()
    {
        $obj = new FloatValueObject(1);
        $this->assertInstanceOf(FloatValueObject::class, $obj);
    }

    /**
     * @test
     */
    public function shouldReturnFloat()
    {
        $obj = FloatValueObject::create(1.5);
        $this->assertIsFloat( $obj->getFloatValue());
    }

    /**
     * @test
     */
    public function shouldReturnInt()
    {
        $obj = FloatValueObject::create(1.5);
        $this->assertIsInt( $obj->getValue());
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfFloatsAreEqual()
    {
        $float1 = FloatValueObject::create(1.02);
        $float2 = FloatValueObject::create(1.02);

        $equals = $float1->equals($float2);

        $this->assertTrue($equals);
    }
    /**
     * @test
     */
    public function shouldReturnFalseIfFloatsAreNotEqual()
    {
        $float1 = FloatValueObject::create(1.02);
        $float2 = FloatValueObject::create(1.002);

        $equals = $float1->equals($float2);

        $this->assertFalse($equals);
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfFloatIsGreaterThanOther()
    {
        $float1 = FloatValueObject::create(1.03);
        $float2 = FloatValueObject::create(1.02);

        $equals = $float1->greaterThan($float2);

        $this->assertTrue($equals);
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfFloatIsNotGreaterThanOther()
    {
        $float1 = FloatValueObject::create(1.02);
        $float2 = FloatValueObject::create(1.02);

        $equals = $float1->greaterThan($float2);

        $this->assertFalse($equals);
    }

    /**
     * @test
     */
    public function shouldReturnTrueIfFloatIsLessThanOther()
    {
        $float1 = FloatValueObject::create(1.01);
        $float2 = FloatValueObject::create(1.02);

        $equals = $float1->lessThan($float2);

        $this->assertTrue($equals);
    }

    /**
     * @test
     */
    public function shouldReturnFalseIfFloatIsNotLessThanOther()
    {
        $float1 = FloatValueObject::create(1.02);
        $float2 = FloatValueObject::create(1.02);

        $equals = $float1->lessThan($float2);

        $this->assertFalse($equals);
    }
}