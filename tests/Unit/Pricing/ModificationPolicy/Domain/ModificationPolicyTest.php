<?php


namespace App\Tests\Unit\Pricing\ModificationPolicy\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\ModificationPolicy\Domain\CheckComplement;
use Pricing\ModificationPolicy\Domain\Complement;
use Pricing\ModificationPolicy\Domain\ModificationPolicy;

class ModificationPolicyTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_correct()
    {
        $modificationPolicy = new ModificationPolicy(
            1,
            1,
            "Modificación 1",
            "Descripción modificación 1",
            "Notas modificación 1",
            new CheckComplement(true,new Complement(2, "Complement 2")),
            new CheckComplement(false,null),
            new CheckComplement(true,new Complement(21, "Complement 21")),
            new CheckComplement(true,new Complement(10, "Complement 10")),
            new CheckComplement(false,null),
            new CheckComplement(false,null),
            new CheckComplement(true,null),
            new CheckComplement(false,null),
            new CheckComplement(false,null),
            new CheckComplement(true,new Complement(17, "Complement 17")),
            new CheckComplement(true,new Complement(27, "Complement 27")),
            new CheckComplement(true,new Complement(36, "Complement 36")),
            new CheckComplement(false,null),
            new CheckComplement(true,new Complement(19, "Complement 19")),
            new CheckComplement(true,new Complement(43, "Complement 43")),
            new CheckComplement(false,null)
        );

        $this->assertEquals(1, $modificationPolicy->getId());
        $this->assertEquals(1, $modificationPolicy->getVersion());
        $this->assertEquals("Modificación 1", $modificationPolicy->getInternalName());
        $this->assertEquals("Descripción modificación 1", $modificationPolicy->getDescription());
        $this->assertEquals("Notas modificación 1", $modificationPolicy->getNotes());
        $this->assertEquals(new CheckComplement(true,new Complement(2, "Complement 2")), $modificationPolicy->getHolderName());
        $this->assertEquals(new CheckComplement(false,null), $modificationPolicy->getHolderDetails());
        $this->assertEquals(new CheckComplement(true,new Complement(21, "Complement 21")), $modificationPolicy->getDelegationPickup());
        $this->assertEquals(new CheckComplement(true,new Complement(10, "Complement 10")), $modificationPolicy->getDelegationDropoff());
        $this->assertEquals(new CheckComplement(false,null), $modificationPolicy->getDelegationPickupOneWay());
        $this->assertEquals(new CheckComplement(false,null), $modificationPolicy->getDelegationDropoffOneWay());
        $this->assertEquals(new CheckComplement(true,null), $modificationPolicy->getDatePickup());
        $this->assertEquals(new CheckComplement(false,null), $modificationPolicy->getDateDropoff());
        $this->assertEquals(new CheckComplement(false,null), $modificationPolicy->getTimePickupNoChangeDays());
        $this->assertEquals(new CheckComplement(true,new Complement(17, "Complement 17")), $modificationPolicy->getTimeDropoffNoChangeDays());
        $this->assertEquals(new CheckComplement(true,new Complement(27, "Complement 27")), $modificationPolicy->getTimePickupChangeDays());
        $this->assertEquals(new CheckComplement(true,new Complement(36, "Complement 36")), $modificationPolicy->getTimeDropoffChangeDays());
        $this->assertEquals(new CheckComplement(false,null), $modificationPolicy->getAfterHoursPickup());
        $this->assertEquals(new CheckComplement(true,new Complement(19, "Complement 19")), $modificationPolicy->getAfterHoursDropoff());
        $this->assertEquals(new CheckComplement(true,new Complement(43, "Complement 43")), $modificationPolicy->getAcriss());
        $this->assertEquals(new CheckComplement(false,null), $modificationPolicy->getFlightId());
    }
}