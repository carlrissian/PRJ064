<?php


namespace App\Tests\Unit\Pricing\Stock\Application\ListComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\ComplementCategory\Domain\ComplementCategoryGetByResponse;
use Pricing\ComplementCategory\Domain\ComplementCategoryNotFoundException;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\ComplementFamily\Domain\ArticleGroup;
use Pricing\ComplementFamily\Domain\ArticleGroupCollection;
use Pricing\ComplementFamily\Domain\ArticleGroupGetByResponse;
use Pricing\ComplementFamily\Domain\ArticleGroupNotFoundException;
use Pricing\ComplementFamily\Domain\ArticleGroupRepository;
use Pricing\Stock\Application\ListComplementArticle\ListComplementArticleResponse;
use Pricing\Stock\Application\ListComplementArticle\ListComplementArticleQuery;
use Pricing\Stock\Application\ListComplementArticle\ListComplementArticleQueryHandler;

class ListComplementArticleQueryHandlerTest extends TestCase
{

    /**
     * @var ComplementCategoryRepository
     */
    private $complementCategoryRepository;
    /**
     * @var ArticleGroupRepository
     */
    private $articleGroupRepository;
    /**
     * @var ListComplementArticleQueryHandler
     */
    private $listComplementArticleQueryHandler;
    /**
     * @var ComplementCategoryGetByResponse
     */
    private $complementCategoryCollection;
    /**
     * @var ArticleGroupGetByResponse
     */
    private $articleGroupCollection;

    protected function setUp()
    {
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->articleGroupRepository = $this->createMock(ArticleGroupRepository::class);
        $this->listComplementArticleQueryHandler = new ListComplementArticleQueryHandler($this->articleGroupRepository, $this->complementCategoryRepository);

        $this->complementCategoryCollection =
            new ComplementCategoryGetByResponse(new ComplementCategoryCollection([
                new ComplementCategory(1,"Item"),
                new ComplementCategory(2,"Servicio"),
                new ComplementCategory(3,"Cobertura"),
                new ComplementCategory(4,"Kilometraje"),
                new ComplementCategory(5,"Fee"),
                new ComplementCategory(6,"Paquete"),
                new ComplementCategory(7,"Combustible")
            ]), 7);

        $this->articleGroupCollection =
           new ArticleGroupGetByResponse(new ArticleGroupCollection([
                new ArticleGroup(1, "Familia 1", new \Pricing\ComplementFamily\Domain\ComplementCategory(1,"Item")),
                new ArticleGroup(2, "Familia 2", new \Pricing\ComplementFamily\Domain\ComplementCategory(2,"Servicio")),
                new ArticleGroup(3, "Familia 3", new \Pricing\ComplementFamily\Domain\ComplementCategory(3,"Cobertura")),
                new ArticleGroup(4, "Familia 4", new \Pricing\ComplementFamily\Domain\ComplementCategory(4,"Kilometraje")),
                new ArticleGroup(5, "Familia 5", new \Pricing\ComplementFamily\Domain\ComplementCategory(5,"Fee")),
                new ArticleGroup(6, "Familia 6", new \Pricing\ComplementFamily\Domain\ComplementCategory(6,"Paquete")),
                new ArticleGroup(7, "Familia 7", new \Pricing\ComplementFamily\Domain\ComplementCategory(7,"Combustible"))
            ]), 7);
    }

    /**
     * @test
     * @throws ComplementCategoryNotFoundException
     * @throws ArticleGroupNotFoundException
     */
    public function should_return_list_articleGroup_complementCategory(){
        $this->articleGroupRepository->method("getBy")->willReturn(
            $this->articleGroupCollection
        );
        $this->complementCategoryRepository->method("getBy")->willReturn(
            $this->complementCategoryCollection
        );

        $response = $this->listComplementArticleQueryHandler->handle(new ListComplementArticleQuery());
        $this->assertInstanceOf(ListComplementArticleResponse::class,$response);

        $this->assertIsArray($response->getArticleGroup());
        $this->assertEquals($response->getArticleGroup(),
            [
                ["id" => 1,"name" => "Familia 1"],
                ["id" => 2,"name" => "Familia 2"],
                ["id" => 3,"name" => "Familia 3"],
                ["id" => 4,"name" => "Familia 4"],
                ["id" => 5,"name" => "Familia 5"],
                ["id" => 6,"name" => "Familia 6"],
                ["id" => 7,"name" => "Familia 7"],
            ]);

        $this->assertIsArray($response->getComplementCategoryList());
        $this->assertEquals($response->getComplementCategoryList(),
            [
                ["id" => 1,"name" => "Item"],
                ["id" => 2,"name" => "Servicio"],
                ["id" => 3,"name" => "Cobertura"],
                ["id" => 4,"name" => "Kilometraje"],
                ["id" => 5,"name" => "Fee"],
                ["id" => 6,"name" => "Paquete"],
                ["id" => 7,"name" => "Combustible"],
            ]);

    }

    /**
     * @test
     */
    public function should_throw_exception_complement_family_not_found(){

        $this->complementCategoryRepository->method("getBy")->willReturn(
            $this->complementCategoryCollection
        );

        $this->expectException(ArticleGroupNotFoundException::class);
        $this->articleGroupRepository->method("getBy")->willReturn(new ArticleGroupGetByResponse(new ArticleGroupCollection([]),0));
        $this->listComplementArticleQueryHandler->handle(new ListComplementArticleQuery());

    }

    /**
     * @test
     */
    public function should_throw_exception_complement_category_not_found(){

        $this->articleGroupRepository->method("getBy")->willReturn(
            $this->articleGroupCollection
        );

        $this->expectException(ComplementCategoryNotFoundException::class);
        $this->complementCategoryRepository->method("getBy")->willReturn(new ComplementCategoryGetByResponse(new ComplementCategoryCollection([]),0));
        $this->listComplementArticleQueryHandler->handle(new ListComplementArticleQuery());

    }

}