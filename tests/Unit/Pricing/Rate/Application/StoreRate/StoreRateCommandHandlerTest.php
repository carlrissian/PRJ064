<?php


namespace App\Tests\Unit\Pricing\Rate\Application\StoreRate;


use PHPUnit\Framework\TestCase;
use Pricing\Rate\Application\StoreRate\StoreRateCommand;
use Pricing\Rate\Application\StoreRate\StoreRateCommandHandler;
use Pricing\Rate\Application\StoreRate\StoreRateResponse;
use Pricing\Rate\Domain\Rate;
use Pricing\Rate\Domain\RateRepository;

class StoreRateCommandHandlerTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|RateRepository
     */
    private $rateRepository;
    /**
     * @var StoreRateCommandHandler
     */
    private $storeRateCommandHandler;

    public function setUp()
    {
        $this->rateRepository = $this->createMock(RateRepository::class);
        $this->storeRateCommandHandler = new StoreRateCommandHandler($this->rateRepository);
    }

    /**
     * @test
     */
    public function should_return_store_rate_response_object()
    {
        $this->rateRepository->method("store")->willReturn(new Rate(1, "Tarifa 1", 1, 1, 1));
        $storeRateCommand = new StoreRateCommand("Tarifa 1",1,1, 1);
        $response = $this->storeRateCommandHandler->handle($storeRateCommand);

        $this->assertInstanceOf(StoreRateResponse::class, $response);
        $this->assertEquals($response->getRateId(), 1);
    }
}