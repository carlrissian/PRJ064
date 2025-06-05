<?php


namespace App\Tests\Unit\Pricing\Stock\Application\FilterComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementArticle\Domain\ComplementRateType;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;
use Pricing\Revenue\Domain\Revenue;
use Pricing\Stock\Application\FilterComplementArticle\FilterComplementArticleQuery;
use Pricing\Stock\Application\FilterComplementArticle\FilterComplementArticleQueryHandler;
use Pricing\Stock\Application\FilterComplementArticle\FilterComplementArticleResponse;
use Pricing\ComplementArticle\Domain\ComplementCategory;
use Pricing\ComplementArticle\Domain\ArticleGroup;
use Pricing\ComplementArticle\Domain\ComplementArticle;
use Pricing\ComplementArticle\Domain\ComplementArticleCollection;
use Pricing\ComplementArticle\Domain\ComplementArticleGetByResponse;

class FilterComplementArticleQueryHandlerTest extends TestCase
{
    /**
     * @var ComplementArticleRepository
     */
    private $complementArticle;
    /**
     * @var FilterComplementArticleQueryHandler
     */
    private $filterComplementArticleQueryHandler;

    protected function setUp()
    {
        $this->complementArticle = $this->createMock(ComplementArticleRepository::class);
        $this->filterComplementArticleQueryHandler = new FilterComplementArticleQueryHandler($this->complementArticle);
    }

    /**
     * @test
     */
    public function should_return_list_complement_type(){

        $this->complementArticle->method("getBy")->willReturn(
            new ComplementArticleGetByResponse(new ComplementArticleCollection([
                new ComplementArticle(1,1,'Nombre interno 1', 'Nombre comercial 1', new ComplementCategory(1, 'Item'), new ArticleGroup(1, 'Familia 1'), new Revenue(1,'Revenue 1'),null, new ComplementRateType(1,'Rate type 1'),true, '', null,null,null),
                new ComplementArticle(2,1,'Nombre interno 2', 'Nombre comercial 2', new ComplementCategory(2, 'Service'), new ArticleGroup(2, 'Familia 2'), new Revenue(1,'Revenue 1'),null, new ComplementRateType(1,'Rate type 1'),true, '', null,null,null),
                new ComplementArticle(3,1,'Nombre interno 3', 'Nombre comercial 3', new ComplementCategory(3, 'Coverage'), new ArticleGroup(3, 'Familia 3'), new Revenue(1,'Revenue 1'),null, new ComplementRateType(1,'Rate type 1'),true, '', null,null,null),
                new ComplementArticle(4,1,'Nombre interno 4', 'Nombre comercial 4', new ComplementCategory(4, 'Mileage'), new ArticleGroup(4, 'Familia 4'), new Revenue(1,'Revenue 1'),null, new ComplementRateType(1,'Rate type 1'),true, '', null,null,null),
                new ComplementArticle(5,1,'Nombre interno 5', 'Nombre comercial 5', new ComplementCategory(5, 'Fee'), new ArticleGroup(5, 'Familia 5'), new Revenue(1,'Revenue 1'),null, new ComplementRateType(1,'Rate type 1'),true, '', null,null,null)
            ]),5)
        );

        $response = $this->filterComplementArticleQueryHandler->handle(new FilterComplementArticleQuery(5,0,null,null, null,null,null,null));
        $this->assertInstanceOf(FilterComplementArticleResponse::class,$response);

        $this->assertIsArray($response->getComplementArticleResponse());
        $this->assertEquals($response->getComplementArticleResponse(),
            ["rows" => [
                ["id" => 1, "internalName" => "Nombre interno 1", "commercialName" => "Nombre comercial 1", "complementCategoryName" => "Item", "articleGroupInternalName" => "Familia 1"],
                ["id" => 2, "internalName" => "Nombre interno 2", "commercialName" => "Nombre comercial 2", "complementCategoryName" => "Service", "articleGroupInternalName" => "Familia 2"],
                ["id" => 3, "internalName" => "Nombre interno 3", "commercialName" => "Nombre comercial 3", "complementCategoryName" => "Coverage", "articleGroupInternalName" => "Familia 3"],
                ["id" => 4, "internalName" => "Nombre interno 4", "commercialName" => "Nombre comercial 4", "complementCategoryName" => "Mileage", "articleGroupInternalName" => "Familia 4"],
                ["id" => 5, "internalName" => "Nombre interno 5", "commercialName" => "Nombre comercial 5", "complementCategoryName" => "Fee", "articleGroupInternalName" => "Familia 5"]
            ],
                "total" => 5,
                "totalNotFiltered" => 100
            ]);
    }

}