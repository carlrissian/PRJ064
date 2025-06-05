<?php


namespace App\Tests\Unit\Pricing\ModificationPolicy\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\ModificationPolicy\Domain\CheckComplement;
use Pricing\ModificationPolicy\Domain\Complement;

class CheckComplementTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_correct()
    {
        $checkComplement = new CheckComplement(true, new Complement(1, "Complement 1"));

        $this->assertEquals(true, $checkComplement->isChecked());
        $this->assertEquals(new Complement(1, "Complement 1"), $checkComplement->getComplement());
    }
}