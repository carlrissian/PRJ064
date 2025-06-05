<?php


namespace App\Tests\Unit\Pricing\FuelPolicy\Application\UpdateFuelPolicy;


use PHPUnit\Framework\TestCase;
use Pricing\FuelPolicy\Application\UpdateFuelPolicy\UpdateFuelPolicyCommand;
use Pricing\FuelPolicy\Application\UpdateFuelPolicy\UpdateFuelPolicyCommandHandler;
use Pricing\FuelPolicy\Application\UpdateFuelPolicy\UpdateFuelPolicyResponse;
use Pricing\FuelPolicy\Domain\FuelPolicy;
use Pricing\FuelPolicy\Domain\FuelPolicyRepository;

class UpdateFuelPolicyCommandHandlerTest extends TestCase
{
    /**
     * @var FuelPolicyRepository
     */
    private $fuelPolicyRepository;
    /**
     * @var UpdateFuelPolicyCommandHandler
     */
    private $updateFuelPolicyCommandHandler;
    protected function setUp()
    {
        $this->fuelPolicyRepository = $this->createMock(FuelPolicyRepository::class);
        $this->updateFuelPolicyCommandHandler = new UpdateFuelPolicyCommandHandler($this->fuelPolicyRepository);
    }
    /**
     * @test
     */
    public function should_return_update_fuelPolicy_response()
    {
        $this->fuelPolicyRepository->method("update")
            ->willReturn(new FuelPolicy(1, 2, "10/11/2019","Full Full","This is a description", "Esto son notas",[1,3,5,7]));

        $response = $this->updateFuelPolicyCommandHandler->handler(new UpdateFuelPolicyCommand(1,"Full Empty","This is a description new","esto son notas new",[1,3,6,7]));

        $this->assertInstanceOf(UpdateFuelPolicyResponse::class,$response);
    }
}