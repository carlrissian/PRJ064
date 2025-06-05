<?php


namespace App\Tests\Unit\Pricing\Complement;


use PHPUnit\Framework\TestCase;
use Pricing\Complement\Domain\ItemComplement;
use Pricing\Complement\Domain\CoverageComplement;
use Pricing\Complement\Domain\FeeComplement;
use Pricing\Complement\Domain\MileageComplement;
use Pricing\Complement\Domain\PackageComplement;
use Pricing\Complement\Domain\ServiceComplement;


class ComplementTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_an_accesoryComplement(){
        $accesoryComplement = new ItemComplement(1,1,1,"15/09/1991 23:42:33",
            "et","quo","Aspernatur nostrum maxime error necessitatibus voluptas",
        "Quae et qui quia expedita.",1,true,true,false,1,false,
            1,30,null,null,null,true);
        $this->assertInstanceOf(ItemComplement::class,$accesoryComplement);
    }

    /**
     * @test
     */
    public function should_be_a_serviceComplement(){
        $serviceComplement = new ServiceComplement(1,1,2,"15/09/1991 23:42:33",
            "et","quo","Aspernatur nostrum maxime error necessitatibus voluptas",
            "Quae et qui quia expedita.",1,true,true,false,1,false,
            1,30,null,null,null,true);
        $this->assertInstanceOf(ServiceComplement::class,$serviceComplement);
    }

    /**
     * @test
     */
    public function should_be_a_coverageComplement(){
        $coverageComplement = new CoverageComplement(1,1,3,"15/09/1991 23:42:33",
            "et","quo","Aspernatur nostrum maxime error necessitatibus voluptas",
            "Quae et qui quia expedita.",1,true,true,false,1,false,
            1,30,null,null,null,[1,2,3],false);
        $this->assertInstanceOf(CoverageComplement::class,$coverageComplement);
    }

    /**
     * @test
     */
    public function should_be_a_mileageComplement(){
        $mileageComplement = new MileageComplement(1,1,4,"15/09/1991 23:42:33",
            "et","quo","Aspernatur nostrum maxime error necessitatibus voluptas",
            "Quae et qui quia expedita.",1,true,true,false,1,false,true);
        $this->assertInstanceOf(MileageComplement::class,$mileageComplement);
    }

    /**
     * @test
     */
    public function should_be_a_feeComplement(){
        $feeComplement = new FeeComplement(1,1,5,"15/09/1991 23:42:33",
            "et","quo","Aspernatur nostrum maxime error necessitatibus voluptas",
            "Quae et qui quia expedita.",1,true,true,false,1,false,
            1,30,null,null,null,true);
        $this->assertInstanceOf(FeeComplement::class,$feeComplement);
    }

    /**
     * @test
     */
    public function should_be_a_packageComplement(){
        $packageComplement = new PackageComplement(1,1,6,"15/09/1991 23:42:33",
            "et","quo","Aspernatur nostrum maxime error necessitatibus voluptas",
            "Quae et qui quia expedita.",1,true,true,false,1,false,
            [1,2,3]);
        $this->assertInstanceOf(PackageComplement::class,$packageComplement);
    }
}