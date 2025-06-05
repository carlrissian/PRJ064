<?php

namespace App\Tests\Unit\Pricing\Family\Domain;

use PHPUnit\Framework\TestCase;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyInvalidArgumentException;

class FamilyTest extends TestCase
{
    /**
     * @test
     * @throws ComplementFamilyInvalidArgumentException
     */
    public function should_be_return_a_family()
    {
        $family = new ComplementFamily(1,"Familia 1",3);
        $this->assertInstanceOf(ComplementFamily::class,$family);
        $this->assertEquals(1, $family->getId());
        $this->assertEquals("Familia 1", $family->getInternalName());
        $this->assertEquals(3, $family->getIdCategory());
    }
}
