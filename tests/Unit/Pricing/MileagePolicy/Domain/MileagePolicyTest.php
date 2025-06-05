<?php


namespace App\Tests\Unit\Pricing\MileagePolicy\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\MileagePolicy\Domain\MileagePolicy;

class MileagePolicyTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_correct()
    {
        $mileagePolicy = new MileagePolicy(1, "Unlimited");

        $this->assertEquals(1, $mileagePolicy->getCode());
        $this->assertEquals("Unlimited", $mileagePolicy->getInternalName());
    }
}