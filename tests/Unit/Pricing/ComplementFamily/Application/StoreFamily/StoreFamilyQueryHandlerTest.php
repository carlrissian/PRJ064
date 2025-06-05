<?php


namespace App\Tests\Unit\Pricing\Family\Application\StoreFamily;


use PHPUnit\Framework\TestCase;
use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\Family\Application\StoreFamily\StoreComplementFamilyCommand;
use Pricing\Family\Application\StoreFamily\StoreComplementFamilyCommandHandler;
use Pricing\Family\Application\StoreFamily\StoreComplementFamilyResponse;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyRepository;

class StoreFamilyQueryHandlerTest extends TestCase
{
    /**
     * @var ComplementFamilyRepository
     */
    private $articleGroupRepository;
    /**
     * @var StoreComplementFamilyCommandHandler
     */
    private $storeFamilyCommandHandler;

    protected function setUp()
    {
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->storeFamilyCommandHandler = new StoreComplementFamilyCommandHandler($this->articleGroupRepository);
    }
    /**
     * @test
     */
    public function should_return_store_family_response()
    {
        $this->articleGroupRepository->method("store")
            ->willReturn(new ComplementFamily(1, "Familia 1", 3));

        $response = $this->storeFamilyCommandHandler->handler(new StoreComplementFamilyCommand("Familia 1",3));

        $this->assertInstanceOf(StoreComplementFamilyResponse::class,$response);

        $this->assertEquals($response->getId(),1);
    }
}