<?php


namespace App\Tests\Unit\Pricing\Rate\Application\CreateRate;



use PHPUnit\Framework\TestCase;
use Pricing\Delegation\Domain\Delegation;
use Pricing\Delegation\Domain\DelegationCollection;
use Pricing\Delegation\Domain\DelegationRepository;
use Pricing\FuelPolicy\Domain\FuelPolicy;
use Pricing\FuelPolicy\Domain\FuelPolicyCollection;
use Pricing\FuelPolicy\Domain\FuelPolicyRepository;
use Pricing\MileagePolicy\Domain\MileagePolicy;
use Pricing\MileagePolicy\Domain\MileagePolicyCollection;
use Pricing\MileagePolicy\Domain\MileagePolicyRepository;
use Pricing\Rate\Application\CreateRate\CreateRateQueryHandler;
use Pricing\Rate\Application\CreateRate\CreateRateResponse;

class CreateRateCommandHandlerTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|DelegationRepository
     */
    private $delegationRepository;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|FuelPolicyRepository
     */
    private $fuelPolicyRepository;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|MileagePolicyRepository
     */
    private $mileagePolicyRepository;
    /**
     * @var CreateRateQueryHandler
     */
    private $createRateCommandHandler;


    public function setUp()
    {
        $this->delegationRepository = $this->createMock(DelegationRepository::class);
        $this->fuelPolicyRepository = $this->createMock(FuelPolicyRepository::class);
        $this->mileagePolicyRepository = $this->createMock(MileagePolicyRepository::class);
        $this->createRateCommandHandler = new CreateRateQueryHandler($this->delegationRepository, $this->fuelPolicyRepository, $this->mileagePolicyRepository);
    }
    
    /**
     * @test
     */
    public function should_return_create_rate_response_object()
    {
        $this->delegationRepository->method("getAll")->willReturn(
            new DelegationCollection([
                new Delegation(1, "Mallorca"),
                new Delegation(2, "Malaga"),
                new Delegation(3, "Alicante"),
            ])
        );
        $this->fuelPolicyRepository->method("getAll")->willReturn(
            new FuelPolicyCollection([
                new FuelPolicy(1, "Full Full"),
                new FuelPolicy(2, "Full Empty"),
            ])
        );
        $this->mileagePolicyRepository->method("getAll")->willReturn(
            new MileagePolicyCollection([
                new MileagePolicy(1, "Limited"),
                new MileagePolicy(2, "Unlimited"),
            ])
        );

        $response = $this->createRateCommandHandler->handle();

        $this->assertInstanceOf(CreateRateResponse::class, $response);
        $this->assertEquals(
            $response->getDelegationArray(),
            [
                1 => ["id" => 1, "name" => "Mallorca"],
                2 => ["id" => 2, "name" => "Malaga"],
                3 => ["id" => 3, "name" => "Alicante"],
            ]
        );
        $this->assertEquals(
            $response->getFuelPolicyArray(),
            [
                1 => ["id" => 1, "name" => "Full Full"],
                2 => ["id" => 2, "name" => "Full Empty"],
            ]
        );
        $this->assertEquals(
            $response->getMileagePolicyArray(),
            [
                1 => ["id" => 1, "name" => "Limited"],
                2 => ["id" => 2, "name" => "Unlimited"],
            ]
        );
    }
}