<?php


namespace App\Tests\Unit\Pricing\Acriss\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\Acriss\Domain\Acriss;
use Pricing\Acriss\Domain\AcrissNotFoundException;

class AcrissTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_an_Acriss(){
        $acriss = new Acriss(1,"MBRM");
        $this->assertInstanceOf(Acriss::class,$acriss);
    }
//
//    /**
//     * @test
//     */
//    public function given_more_than_four_letters_acriss_thrown_exception(){
//        $this->expectException(AcrissNotFoundException::class);
//        new Acriss(1,"MBRAM");
//    }
//
//    /**
//     * @test
//     */
//    public function given_not_uppercase_letters_acriss_thrown_exception(){
//        $this->expectException(AcrissNotFoundException::class);
//        new Acriss(1,"MBgA");
//    }
//
//    /**
//     * @test
//     */
//    public function given_a_number_acriss_thrown_exception(){
//        $this->expectException(AcrissNotFoundException::class);
//        new Acriss(1,"1BGF");
//    }

}