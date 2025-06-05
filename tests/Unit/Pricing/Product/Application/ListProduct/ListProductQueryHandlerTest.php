<?php


namespace App\Tests\Unit\Pricing\Product\Application\ListProduct;


use PHPUnit\Framework\TestCase;
use Pricing\Product\Application\ListProduct\ListProductQuery;
use Pricing\Product\Application\ListProduct\ListProductQueryHandler;
use Pricing\Product\Application\ListProduct\ListProductResponse;
use Pricing\Product\Domain\Product;
use Pricing\Product\Domain\ProductCollection;
use Pricing\Product\Domain\ProductRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ListProductQueryHandlerTest extends TestCase
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ListProductQueryHandler
     */
    private $listProductQueryHandler;

    protected function setUp()
    {
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->listProductQueryHandler = new ListProductQueryHandler($this->productRepository,new Serializer([], [new JsonEncoder()]));
    }

    /**
     * @test
     */
    public function should_return_list_product_response()
    {
        $this->productRepository->method("getAll")->willReturn(
            new ProductCollection([
                new Product(1, 2,"Producto 1", "PR 1","Description 1","Notes 1",1,6,[1,3,5],null),
                new Product(2, 3,"Producto 2", "PR 2","Description 2","Notes 2",2,5,[1,2,4],null),
                new Product(3, 2,"Producto 3", "PR 3","Description 3","Notes 3",10,7,[2,4,5],null),
                new Product(4, 5,"Producto 4", "PR 4","Description 4","Notes 4",3,9,[1,3,5],null),
                new Product(5, 6,"Producto 5", "PR 5","Description 5","Notes 5",4,8,[1,3,5],null),
            ])
        );

        $response = $this->listProductQueryHandler->handler(new ListProductQuery());

        $this->assertInstanceOf(ListProductResponse::class,$response);
        $this->assertEquals($response->getDataProduct(),
            '[{"id":1,"code":"PR 1","internalName":"Producto 1","description":"Description 1"},{"id":2,"code":"PR 2","internalName":"Producto 2","description":"Description 2"},{"id":3,"code":"PR 3","internalName":"Producto 3","description":"Description 3"},{"id":4,"code":"PR 4","internalName":"Producto 4","description":"Description 4"},{"id":5,"code":"PR 5","internalName":"Producto 5","description":"Description 5"}]'
        );
    }
}