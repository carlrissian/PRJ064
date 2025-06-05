<?php


namespace App\Tests\Unit\Pricing\Revenue\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\Revenue\Domain\Revenue;

class RevenueTest extends TestCase
{
    /**
     * @test
     */
    public function must_be_return_a_revenue(){
        $revenue = new Revenue(1,"Revenue 1");
        $this->assertInstanceOf(Revenue::class,$revenue);
    }

}