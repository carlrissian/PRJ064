<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Application\ListComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Domain\ComplementFamilyCollection;
use Pricing\Family\Domain\ComplementFamilyRepository;
use Pricing\ComplementArticle\Application\ListComplementArticle\ListComplementArticleQuery;
use Pricing\ComplementArticle\Application\ListComplementArticle\ListComplementArticleQueryHandler;
use Pricing\ComplementArticle\Application\ListComplementArticle\ListComplementArticleResponse;
use Pricing\ComplementArticle\Domain\ComplementArticleCollection;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;
use Pricing\ComplementArticle\Domain\ComplementArticle;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ListComplementArticleQueryHandlerTest extends TestCase
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
     * @var ListComplementArticleQueryHandler
     */
    private $listComplementArticleQueryHandler;

    protected function setUp()
    {
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->complementArticleRepository = $this->createMock(ComplementArticleRepository::class);

        $this->listComplementArticleQueryHandler = new ListComplementArticleQueryHandler(new Serializer([], [new JsonEncoder()]),$this->complementArticleRepository,$this->complementCategoryRepository,$this->articleGroupRepository);
    }
    /**
     * @test
     */
    public function should_return_list_complementArticle_response_object(){
        $this->complementArticleRepository->method("getAll")->willReturn(
            new ComplementArticleCollection([
                new ComplementArticle(1, "GoPad", "GP",1,7),
                new ComplementArticle(1, "Conductor Adicional", "AD",4,5),
                new ComplementArticle(1, "Sillita de bebe", "SB",3,4),
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
        $this->complementCategoryRepository->method("getAll")->willReturn(
            new ComplementCategoryCollection([
                new ComplementCategory(1,"Accesorio"),
                new ComplementCategory(2,"Servicio"),
                new ComplementCategory(3,"Cobertura"),
                new ComplementCategory(4,"Kilometraje"),
                new ComplementCategory(5,"Fee"),
                new ComplementCategory(6,"Paquete"),
                new ComplementCategory(7,"Combustible"),
            ])
        );


        $response = $this->listComplementArticleQueryHandler->handler(new ListComplementArticleQuery());

        $this->assertInstanceOf(ListComplementArticleResponse::class,$response);
        $this->assertEquals($response->getData(),'[{"id":1,"name":"GoPad","key":"GP","categoryName":"Accesorio","familyName":"Familia 7"},{"id":1,"name":"Conductor Adicional","key":"AD","categoryName":"Kilometraje","familyName":"Familia 5"},{"id":1,"name":"Sillita de bebe","key":"SB","categoryName":"Cobertura","familyName":"Familia 4"}]');
    }
}