<?php


namespace App\Tests\Unit\Pricing\Family\Application\ListFamily;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Application\ListFamily\ListComplementFamilyQuery;
use Pricing\Family\Application\ListFamily\ListComplementFamilyQueryHandler;
use Pricing\Family\Application\ListFamily\ListComplementFamilyResponse;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyCollection;
use Pricing\Family\Domain\ComplementFamilyRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ListFamilyQueryHandlerTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|ComplementFamilyRepository
     */
    private $articleGroupRepository;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|ComplementCategoryRepository
     */
    private $complementCategoryRepository;
    /**
     * @var ListComplementFamilyQueryHandler
     */
    private $listFamilyQueryHandler;

    protected function setUp()
    {
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->listFamilyQueryHandler = new ListComplementFamilyQueryHandler(new Serializer([], [new JsonEncoder()]), $this->articleGroupRepository, $this->complementCategoryRepository);
    }

    /**
     * @test
     */
    public function should_return_list_family_response_object(){

        $this->articleGroupRepository->method("getAll")->willReturn(
            new ComplementFamilyCollection([
                new ComplementFamily(1, "Familia 1", 2),
                new ComplementFamily(2, "Familia 2", 3),
                new ComplementFamily(3, "Familia 3", 1),
                new ComplementFamily(3, "Familia 4", 5),
                new ComplementFamily(3, "Familia 5", 4),
                new ComplementFamily(3, "Familia 6", 7),
                new ComplementFamily(3, "Familia 7", 6),
            ])
        );
        $this->complementCategoryRepository->method("getAll")->willReturn(
            new ComplementCategoryCollection([
                new ComplementCategory(1,"Item"),
                new ComplementCategory(2,"Servicio"),
                new ComplementCategory(3,"Cobertura"),
                new ComplementCategory(4,"Kilometraje"),
                new ComplementCategory(5,"Fee"),
                new ComplementCategory(6,"Paquete"),
                new ComplementCategory(7,"Combustible"),
            ])
        );
        $response = $this->listFamilyQueryHandler->handler(new ListComplementFamilyQuery());

        $this->assertInstanceOf(ListComplementFamilyResponse::class,$response);
        $this->assertEquals(
            $response->getDataFamily(),
            '[{"id":1,"name":"Familia 1","categoryName":"Servicio"},{"id":2,"name":"Familia 2","categoryName":"Cobertura"},{"id":3,"name":"Familia 3","categoryName":"Accesorio"},{"id":3,"name":"Familia 4","categoryName":"Fee"},{"id":3,"name":"Familia 5","categoryName":"Kilometraje"},{"id":3,"name":"Familia 6","categoryName":"Combustible"},{"id":3,"name":"Familia 7","categoryName":"Paquete"}]'
        );
    }
}