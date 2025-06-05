<?php


namespace App\Tests\Unit\Pricing\Product\Application\StoreProduct;


use PHPUnit\Framework\TestCase;
use Pricing\Product\Application\StoreProduct\StoreProductCommand;
use Pricing\Product\Application\StoreProduct\StoreProductCommandHandler;
use Pricing\Product\Application\StoreProduct\StoreProductResponse;
use Pricing\Product\Domain\Product;
use Pricing\Product\Domain\ProductRepository;

class StoreProductCommandHandlerTest extends TestCase
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var StoreProductCommandHandler
     */
    private $storeProductCommandHandler;

    protected function setUp()
    {
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->storeProductCommandHandler = new StoreProductCommandHandler($this->productRepository);
    }

    /**
     * @test
     */
    public function should_return_store_product_response()
    {
        $this->productRepository->method("store")
            ->willReturn(new Product(1, 2,"Producto 1", "PR1", "Descripcion producto 1","Notes Product 1",1,2,[1,3,5],null));

        $response = $this->storeProductCommandHandler->handler(new StoreProductCommand("PR1","Producto 1","Descripcion producto 1","Notes Product 1",1,2,[1,3,5],null));

        $this->assertInstanceOf(StoreProductResponse::class, $response);

        $this->assertEquals($response->getId(),1);
    }
}