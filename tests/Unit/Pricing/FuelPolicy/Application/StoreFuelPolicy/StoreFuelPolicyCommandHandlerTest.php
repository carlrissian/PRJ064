<?php


namespace App\Tests\Unit\Pricing\FuelPolicy\Application\StoreFuelPolicy;


use PHPUnit\Framework\TestCase;
use Pricing\FuelPolicy\Application\StoreFuelPolicy\StoreFuelPolicyCommand;
use Pricing\FuelPolicy\Application\StoreFuelPolicy\StoreFuelPolicyCommandHandler;
use Pricing\FuelPolicy\Application\StoreFuelPolicy\StoreFuelPolicyResponse;
use Pricing\FuelPolicy\Domain\FuelPolicy;
use Pricing\FuelPolicy\Domain\FuelPolicyRepository;

class StoreFuelPolicyCommandHandlerTest extends TestCase
{
    /**
     * @var FuelPolicyRepository
     */
    private $fuelPolicyRepository;
    /**
     * @var StoreFuelPolicyCommandHandler
     */
    private $storeFuelPolicyCommandHandler;
    protected function setUp()
    {
        $this->fuelPolicyRepository = $this->createMock(FuelPolicyRepository::class);
        $this->storeFuelPolicyCommandHandler = new StoreFuelPolicyCommandHandler($this->fuelPolicyRepository);
    }
    /**
     * @test
     */
    public function should_return_store_fuelPolicy_response()
    {
        $this->fuelPolicyRepository->method("store")
            ->willReturn(new FuelPolicy(1, 2, "10/11/2019","Full Full","This is a description", "Esto son notas",[1,3,5,7]));
        $response = $this->storeFuelPolicyCommandHandler->handler(new StoreFuelPolicyCommand("Full Full","This is a description", "Esto son notas",[1,3,5,7]));

        $this->assertInstanceOf(StoreFuelPolicyResponse::class,$response);

        $this->assertEquals($response->getId(), 1);
    }
}