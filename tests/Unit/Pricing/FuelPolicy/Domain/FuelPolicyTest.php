<?php


namespace App\Tests\Unit\Pricing\FuelPolicy\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\FuelPolicy\Domain\FuelPolicy;

class FuelPolicyTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_correct()
    {
        $fuelPolicy = new FuelPolicy(1, 2, "11/11/2019","Full Full","This is a description", "Esto son notas",[1,3,5,7]);

        $this->assertEquals(1, $fuelPolicy->getCode());
        $this->assertEquals(2, $fuelPolicy->getVersion());
        $this->assertEquals("11/11/2019", $fuelPolicy->getCreationDate());
        $this->assertEquals("Full Full", $fuelPolicy->getInternalName());
        $this->assertEquals("This is a description", $fuelPolicy->getDescription());
        $this->assertEquals("Esto son notas", $fuelPolicy->getNotes());
        $this->assertEquals([1,3,5,7], $fuelPolicy->getComplements());
    }
}