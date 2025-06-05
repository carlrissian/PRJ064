<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Application\EditComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyCollection;
use Pricing\Family\Domain\ComplementFamilyRepository;
use Pricing\ComplementArticle\Application\EditComplementArticle\EditComplementArticleQuery;
use Pricing\ComplementArticle\Application\EditComplementArticle\EditComplementArticleQueryHandler;
use Pricing\ComplementArticle\Application\EditComplementArticle\EditComplementArticleResponse;
use Pricing\ComplementArticle\Domain\ComplementArticle;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;

class EditComplementArticleQueryHandlerTest extends TestCase
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
     * @var ComplementArticleRepository
     */
    private $complementArticleRepository;
    /**
     * @var EditComplementArticleQueryHandler
     */
    private $editComplementArticleQueryHandler;

    protected function setUp()
    {
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->complementArticleRepository = $this->createMock(ComplementArticleRepository::class);
        $this->editComplementArticleQueryHandler = new EditComplementArticleQueryHandler($this->complementArticleRepository,$this->complementCategoryRepository,$this->articleGroupRepository);
    }
    /**
     * @test
     */
    public function should_return_edit_complementArticle_response()
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
        $this->articleGroupRepository->method("getAll")->willReturn(
            new ComplementFamilyCollection([
                new ComplementFamily(1, "Familia 1", 2),
                new ComplementFamily(2, "Familia 2", 3),
                new ComplementFamily(3, "Familia 3", 1),
                new ComplementFamily(4, "Familia 4", 5),
                new ComplementFamily(5, "Familia 5", 4),
                new ComplementFamily(6, "Familia 6", 7),
                new ComplementFamily(7, "Familia 7", 6),
            ])
        );
        $this->complementArticleRepository->method("getById")
            ->will($this->returnValueMap([
                [1, new ComplementArticle(1,"GoPad","GP",1,7)],
                [2, new ComplementArticle(2,"Conductor Adicional","AD",4,5)],
                [3, new ComplementArticle(3,"Sillita de bebe","SB",3,4)],
            ]));

        $response = $this->editComplementArticleQueryHandler->handler(new EditComplementArticleQuery(3));

        $this->assertInstanceOf(EditComplementArticleResponse::class,$response);

        $this->assertEquals($response->getComplementCategoryArray(),
            [
                ["id" => 1, "name" => "Accesorio"],
                ["id" => 2, "name" => "Servicio"],
                ["id" => 3, "name" => "Cobertura"],
                ["id" => 4, "name" => "Kilometraje"],
                ["id" => 5, "name" => "Fee"],
                ["id" => 6, "name" => "Paquete"],
                ["id" => 7, "name" => "Combustible"]
            ]);
        $this->assertEquals($response->getComplementfamilyArray(),
            [
                ["id" => 1, "name" => "Familia 1", "idCategory" => 2],
                ["id" => 2, "name" => "Familia 2", "idCategory" => 3],
                ["id" => 3, "name" => "Familia 3", "idCategory" => 1],
                ["id" => 4, "name" => "Familia 4", "idCategory" => 5],
                ["id" => 5, "name" => "Familia 5", "idCategory" => 4],
                ["id" => 6, "name" => "Familia 6", "idCategory" => 7],
                ["id" => 7, "name" => "Familia 7", "idCategory" => 6]
            ]);
        $this->assertEquals($response->getName(),"Sillita de bebe");
        $this->assertEquals($response->getIdCategory(),3);
        $this->assertEquals($response->getIdFamily(),4);
        $this->assertEquals($response->getKey(),"SB");
    }
}