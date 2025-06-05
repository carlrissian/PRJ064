<?php


namespace App\Tests\Unit\Pricing\Carclass\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\Carclass\Domain\Carclass;

class CarclassTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_a_carclass(){
        $carclass = new Carclass(1,"Mini");
        $this->assertInstanceOf(Carclass::class, $carclass);
    }
}