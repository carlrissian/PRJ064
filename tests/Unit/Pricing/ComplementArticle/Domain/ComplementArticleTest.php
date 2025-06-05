<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementArticle\Domain\ComplementArticle;

class ComplementArticleTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_a_complementArticle(){
        $complementArticle = new ComplementArticle(1,"GoPad", "GP" , 1, 7);
        $this->assertInstanceOf(ComplementArticle::class,$complementArticle);
    }
}