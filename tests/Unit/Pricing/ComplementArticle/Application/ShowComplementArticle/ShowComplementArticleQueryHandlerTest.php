<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Application\ShowComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyRepository;
use Pricing\ComplementArticle\Application\ShowComplementArticle\ShowComplementArticleQuery;
use Pricing\ComplementArticle\Application\ShowComplementArticle\ShowComplementArticleQueryHandler;
use Pricing\ComplementArticle\Application\ShowComplementArticle\ShowComplementArticleResponse;
use Pricing\ComplementArticle\Domain\ComplementArticle;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;

class ShowComplementArticleQueryHandlerTest extends TestCase
{
    /**
     * @var ComplementArticleRepository
     */
    private $complementArticleRepository;
    /**
     * @var ComplementCategoryRepository
     */
    private $complementCategoryRepository;
    /**
     * @var ComplementFamilyRepository
     */
    private $articleGroupRepository;
    /**
     * @var ShowComplementArticleQueryHandler
     */
    private $showComplementArticleQueryHandler;
    protected function setUp()
    {
        $this->complementArticleRepository = $this->createMock(ComplementArticleRepository::class);
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);

        $this->showComplementArticleQueryHandler = new ShowComplementArticleQueryHandler($this->complementArticleRepository,$this->complementCategoryRepository,$this->articleGroupRepository);
    }
    /**
     * @test
     */
    public function should_return_show_complementArticle_response()
    {
        $this->complementArticleRepository->method("getById")
            ->will($this->returnValueMap([
                [1, new ComplementArticle(1,"GoPad","GP",1,7)],
                [2, new ComplementArticle(2,"Conductor Adicional","AD",4,5)],
                [3, new ComplementArticle(3,"Sillita de bebe","SB",3,4)],
            ]));

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

        $response = $this->showComplementArticleQueryHandler->handler(new ShowComplementArticleQuery(1));

        $this->assertInstanceOf(ShowComplementArticleResponse::class,$response);

        $this->assertEquals($response->getName(), "GoPad");
        $this->assertEquals($response->getKey(), "GP");
        $this->assertEquals($response->getCategoryName(), "Accesorio");
        $this->assertEquals($response->getFamilyName(), "Familia 7");
    }
}