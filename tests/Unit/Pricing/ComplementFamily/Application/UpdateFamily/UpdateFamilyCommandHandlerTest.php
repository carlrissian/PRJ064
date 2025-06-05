<?php


namespace App\Tests\Unit\Pricing\Family\Application\UpdateFamily;


use PHPUnit\Framework\TestCase;
use Pricing\Family\Application\UpdateFamily\UpdateComplementFamilyCommand;
use Pricing\Family\Application\UpdateFamily\UpdateComplementFamilyCommandHandler;
use Pricing\Family\Application\UpdateFamily\UpdateComplementFamilyResponse;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyRepository;

class UpdateFamilyCommandHandlerTest extends TestCase
{
    /**
     * @var ComplementFamilyRepository
     */
    private $articleGroupRepository;
    /**
     * @var UpdateComplementFamilyCommandHandler
     */
    private $updateFamilyCommandHandler;

    protected function setUp()
    {
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->updateFamilyCommandHandler = new UpdateComplementFamilyCommandHandler($this->articleGroupRepository);
    }

    /**
     * @test
     */
    public function should_return_update_family_response()
    {
        $this->articleGroupRepository->method("update")
            ->willReturn(new ComplementFamily(1, "Familia 1", 3));

        $response = $this->updateFamilyCommandHandler->handler(new UpdateComplementFamilyCommand(1, "Familia 1", 3));

        $this->assertInstanceOf(UpdateComplementFamilyResponse::class, $response);
    }
}