<?php


namespace App\Tests\Unit\Pricing\Family\Application\ShowFamily;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Application\ShowFamily\ShowComplementFamilyQuery;
use Pricing\Family\Application\ShowFamily\ShowComplementFamilyQueryHandler;
use Pricing\Family\Application\ShowFamily\ShowComplementFamilyResponse;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyRepository;


class ShowFamilyQueryHandlerTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | ComplementCategoryRepository
     */
    private $complementCategoryRepository;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | ComplementFamilyRepository
     */
    private $articleGroupRepository;
    /**
     * @var ShowComplementFamilyQueryHandler
     */
    private $showFamilyQueryHandler;

    protected function setUp()
    {
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->showFamilyQueryHandler = new ShowComplementFamilyQueryHandler($this->articleGroupRepository,$this->complementCategoryRepository);
    }
    /**
     * @test
     */
    public function should_return_family_response()
    {
        $this->articleGroupRepository->method("getById")
            ->will($this->returnValueMap([
                [1, new ComplementFamily(1,"Familia 1",2)],
                [2, new ComplementFamily(2,"Familia 2",5)],
                [3, new ComplementFamily(3,"Familia 3",5)],
                [4, new ComplementFamily(4,"Familia 4",3)],
                [5, new ComplementFamily(5,"Familia 5",1)],
                [6, new ComplementFamily(6,"Familia 6",7)],
                [7, new ComplementFamily(7,"Familia 7",6)],
            ]));

        $this->complementCategoryRepository->method("getById")
            ->will($this->returnValueMap([
                [1, new ComplementCategory(1,"Accesorio")],
                [2, new ComplementCategory(2,"Servicio")],
                [3, new ComplementCategory(3,"Cobertura")],
                [4, new ComplementCategory(4,"Kilometraje")],
                [5, new ComplementCategory(5,"Fee")],
                [6, new ComplementCategory(6,"Paquete")],
                [7, new ComplementCategory(7,"Combustible")],
            ]));

        $response = $this->showFamilyQueryHandler->handler(new ShowComplementFamilyQuery(1));
        $this->assertInstanceOf(ShowComplementFamilyResponse::class,$response);

        $this->assertEquals($response->getName(),"Familia 1");
        $this->assertEquals($response->getCategoryName(),"Servicio");
    }
}