<?php


namespace App\Tests\Unit\Pricing\Delegation\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\Delegation\Domain\Delegation;

class DelegationTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_correct()
    {
        $delegation = new Delegation(1, "Mallorca");

        $this->assertEquals(1, $delegation->getId());
        $this->assertEquals("Mallorca", $delegation->getName());
    }

    /**
     * @test
     */
    public function should_be_return_a_delegation()
    {
        $delegation = new Delegation(1,"Mallorca");
        $this->assertInstanceOf(Delegation::class,$delegation);
    }
}