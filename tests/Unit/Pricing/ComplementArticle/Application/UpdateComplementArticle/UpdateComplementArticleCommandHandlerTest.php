<?php


namespace App\Tests\Unit\Pricing\ComplementArticle\Application\UpdateComplementArticle;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementArticle\Application\UpdateComplementArticle\UpdateComplementArticleCommand;
use Pricing\ComplementArticle\Application\UpdateComplementArticle\UpdateComplementArticleCommandHandler;
use Pricing\ComplementArticle\Application\UpdateComplementArticle\UpdateComplementArticleResponse;
use Pricing\ComplementArticle\Domain\ComplementArticle;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;

class UpdateComplementArticleCommandHandlerTest extends TestCase
{
    /**
     * @var ComplementArticleRepository
     */
    private $complementArticleRepository;
    /**
     * @var UpdateComplementArticleCommandHandler
     */
    private $updateComplementArticleCommandHandler;

    protected function setUp()
    {
        $this->complementArticleRepository = $this->createMock(ComplementArticleRepository::class);
        $this->updateComplementArticleCommandHandler = new UpdateComplementArticleCommandHandler($this->complementArticleRepository);
    }

    /**
     * @test
     */
    public function should_return_update_complementArticle_response()
    {
        $this->complementArticleRepository->method("update")
            ->willReturn(new ComplementArticle(1,"GoPad","GP",1,7));

        $response = $this->updateComplementArticleCommandHandler->handler(new UpdateComplementArticleCommand(1,"GoPad","GP",1,7));

        $this->assertInstanceOf(UpdateComplementArticleResponse::class,$response);
    }
}