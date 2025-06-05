<?php


namespace App\Tests\Unit\Pricing\ComplementCategory\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;

class ComplementCategoryTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_a_complementCategory(){
        $complementCategory = new ComplementCategory(1, "Accesorio");
        $this->assertInstanceOf(ComplementCategory::class,$complementCategory);
    }
}