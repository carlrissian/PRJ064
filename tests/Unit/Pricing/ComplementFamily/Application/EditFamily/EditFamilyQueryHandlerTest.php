<?php


namespace App\Tests\Unit\Pricing\Family\Application\EditFamily;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Application\EditFamily\EditComplementFamilyQuery;
use Pricing\Family\Application\EditFamily\EditComplementFamilyQueryHandler;
use Pricing\Family\Application\EditFamily\EditComplementFamilyResponse;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyRepository;

class EditFamilyQueryHandlerTest extends TestCase
{
    /**
     * @var ComplementCategoryRepository
     */
    private $complementCategoryRepository;
    /**
     * @var ComplementFamilyRepository
     */
    private $articleGroupRepository;
    /**
     * @var EditComplementFamilyQueryHandler
     */
    private $editFamilyQueryHandler;
    protected function setUp()
    {
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->editFamilyQueryHandler = new EditComplementFamilyQueryHandler($this->articleGroupRepository,$this->complementCategoryRepository);
    }
    /**
     * @test
     */
    public function should_return_edit_family_response()
    {
        $this->complementCategoryRepository->method("getAll")
            ->willReturn(new ComplementCategoryCollection([
                    new ComplementCategory(1, "Accesorio"),
                    new ComplementCategory(2, "Servicio"),
                    new ComplementCategory(3, "Cobertura"),
                    new ComplementCategory(4, "Kilometraje"),
                    new ComplementCategory(5, "Fee"),
                    new ComplementCategory(6, "Paquete"),
                    new ComplementCategory(7, "Combustible"),
                ])
            );

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

        $response = $this->editFamilyQueryHandler->handler(new EditComplementFamilyQuery(2));
        $this->assertInstanceOf(EditComplementFamilyResponse::class,$response);

        $this->assertEquals($response->getFamilyInternalName(),"Familia 2");
        $this->assertEquals($response->getFamilyIdCategory(),5);
        $this->assertEquals(
            $response->getCategoryArray(),
            [
                ["id" => 1, "name" => "Accesorio"],
                ["id" => 2, "name" => "Servicio"],
                ["id" => 3, "name" => "Cobertura"],
                ["id" => 4, "name" => "Kilometraje"],
                ["id" => 5, "name" => "Fee"],
                ["id" => 6, "name" => "Paquete"],
                ["id" => 7, "name" => "Combustible"]
            ]
        );
    }
}