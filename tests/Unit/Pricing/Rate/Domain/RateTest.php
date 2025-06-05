<?php


namespace App\Tests\Unit\Pricing\Rate\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\Rate\Domain\Rate;

class RateTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_correct()
    {
        $rate = new Rate(1, "Tarifa1", 1, 1, 1);

        $this->assertEquals(1, $rate->getId());
        $this->assertEquals("Tarifa1", $rate->getName());
        $this->assertEquals(1, $rate->getDelegationId());
        $this->assertEquals(1, $rate->getFuelPolicyCode());
        $this->assertEquals(1, $rate->getMileagePolicyCode());
    }
}