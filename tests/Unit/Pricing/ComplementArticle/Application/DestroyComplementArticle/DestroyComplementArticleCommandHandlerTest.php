<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Application\DestroyComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementArticle\Application\DestroyComplementArticle\DestroyComplementArticleCommand;
use Pricing\ComplementArticle\Application\DestroyComplementArticle\DestroyComplementArticleCommandHandler;
use Pricing\ComplementArticle\Application\DestroyComplementArticle\DestroyComplementArticleResponse;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;

class DestroyComplementArticleCommandHandlerTest extends TestCase
{
    /**
     * @var ComplementArticleRepository
     */
    private $complementArticleRepository;
    /**
     * @var DestroyComplementArticleCommandHandlerTest
     */
    private $destroyComplementArticleCommandHandler;

    protected function setUp()
    {
        $this->complementArticleRepository = $this->createMock(ComplementArticleRepository::class);
        $this->destroyComplementArticleCommandHandler = new DestroyComplementArticleCommandHandler($this->complementArticleRepository);
    }
    /**
     * @test
     */
    public function should_destroy_complementArticle()
    {
        $response = $this->destroyComplementArticleCommandHandler->handler(new DestroyComplementArticleCommand(1));
        $this->assertInstanceOf(DestroyComplementArticleResponse::class,$response);
    }
}