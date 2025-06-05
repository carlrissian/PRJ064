<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Application\CreateComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyCollection;
use Pricing\Family\Domain\ComplementFamilyRepository;
use Pricing\ComplementArticle\Application\CreateComplementArticle\CreateComplementArticleQuery;
use Pricing\ComplementArticle\Application\CreateComplementArticle\CreateComplementArticleQueryHandler;
use Pricing\ComplementArticle\Application\CreateComplementArticle\CreateComplementArticleResponse;

class CreateComplementArticleQueryHandlerTest extends TestCase
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
     * @var CreateComplementArticleQueryHandler
     */
    private $createComplementArticleQueryHandler;

    protected function setUp()
    {
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->createComplementArticleQueryHandler = new CreateComplementArticleQueryHandler($this->complementCategoryRepository,$this->articleGroupRepository);
    }

    /**
     * @test
     * @throws \Pricing\Family\Domain\ComplementFamilyInvalidArgumentException
     */
    public function should_return_create_complementArticle_response()
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

        $response = $this->createComplementArticleQueryHandler->handle(new CreateComplementArticleQuery());
        $this->assertInstanceOf(CreateComplementArticleResponse::class,$response);

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
        $this->assertEquals($response->getFamilyArray(),
            [
                ["id" => 1, "name" => "Familia 1", "categoryId" => 2],
                ["id" => 2, "name" => "Familia 2", "categoryId" => 3],
                ["id" => 3, "name" => "Familia 3", "categoryId" => 1],
                ["id" => 4, "name" => "Familia 4", "categoryId" => 5],
                ["id" => 5, "name" => "Familia 5", "categoryId" => 4],
                ["id" => 6, "name" => "Familia 6", "categoryId" => 7],
                ["id" => 7, "name" => "Familia 7", "categoryId" => 6],
            ]);
    }
}