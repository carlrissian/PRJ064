<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Application\StoreComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementArticle\Application\StoreComplementArticle\StoreComplementArticleCommand;
use Pricing\ComplementArticle\Application\StoreComplementArticle\StoreComplementArticleCommandHandler;
use Pricing\ComplementArticle\Application\StoreComplementArticle\StoreComplementArticleResponse;
use Pricing\ComplementArticle\Domain\ComplementArticle;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;

class StoreComplementArticleCommandHandlerTest extends TestCase
{
    /**
     * @var ComplementArticleRepository
     */
    private $complementArticleRepository;
    /**
     * @var StoreComplementArticleCommandHandler
     */
    private $storeComplementArticleCommandHandler;

    protected function setUp()
    {
        $this->complementArticleRepository = $this->createMock(ComplementArticleRepository::class);
        $this->storeComplementArticleCommandHandler = new StoreComplementArticleCommandHandler($this->complementArticleRepository);
    }

    /**
     * @test
     */
    public function should_return_store_complementArticle_response()
    {
        $this->complementArticleRepository->method("store")
            ->willReturn(new ComplementArticle(1,"GoPad","GP",1,7));

        $response = $this->storeComplementArticleCommandHandler->handle(new StoreComplementArticleCommand("GoPad","GP",1,7));

        $this->assertInstanceOf(StoreComplementArticleResponse::class,$response);

        $this->assertEquals($response->getId(),1);
    }
}