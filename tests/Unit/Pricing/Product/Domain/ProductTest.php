<?php


namespace App\Tests\Unit\Pricing\Product\Domain;


use PHPUnit\Framework\TestCase;
use Pricing\Product\Domain\Product;

class ProductTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_correct()
    {
        $product = new Product(1,2,"Producto 1", "p1" , "Aut qui non possimus.", "Perferendis hic eos porro accusantium in nostrum corporis.",1,2,[1,2,3],null);

        $this->assertEquals(1, $product->getId());
        $this->assertEquals(2, $product->getVersion());
        $this->assertEquals("p1", $product->getCode());
        $this->assertEquals("Aut qui non possimus.", $product->getDescription());
        $this->assertEquals("Perferendis hic eos porro accusantium in nostrum corporis.", $product->getNotes());
        $this->assertEquals(1, $product->getIdFuelRateType());
        $this->assertEquals(2, $product->getIdMileage());
        $this->assertEquals([1,2,3], $product->getRates());
        $this->assertEquals(null, $product->getCondition());
    }
    /**
     * @test
     */
    public function should_be_a_product(){
        $product = new Product(1,2,"Producto 1", "p1" , "Aut qui non possimus.", "Perferendis hic eos porro accusantium in nostrum corporis.",1,2,[1,2,3],null);
        $this->assertInstanceOf(Product::class,$product);
    }
}