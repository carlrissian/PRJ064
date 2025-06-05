<?php


namespace App\Tests\Unit\Pricing\Rate\Application\ShowRate;


use PHPUnit\Framework\TestCase;
use Pricing\Delegation\Domain\Delegation;
use Pricing\Delegation\Domain\DelegationRepository;
use Pricing\FuelPolicy\Domain\FuelPolicy;
use Pricing\FuelPolicy\Domain\FuelPolicyRepository;
use Pricing\MileagePolicy\Domain\MileagePolicy;
use Pricing\MileagePolicy\Domain\MileagePolicyRepository;
use Pricing\Rate\Application\EditRate\EditRateQuery;
use Pricing\Rate\Application\EditRate\EditRateQueryHandler;
use Pricing\Rate\Application\EditRate\EditRateResponse;
use Pricing\Rate\Domain\Rate;
use Pricing\Rate\Domain\RateRepository;

class ShowRateQueryHandlerTest extends TestCase
{
    /**
     * @var EditRateQueryHandler
     */
    private $showRateQueryHandler;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|RateRepository
     */
    private $rateRepository;
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

    public function setUp()
    {
        $this->rateRepository = $this->createMock(RateRepository::class);
        $this->delegationRepository = $this->createMock(DelegationRepository::class);
        $this->fuelPolicyRepository = $this->createMock(FuelPolicyRepository::class);
        $this->mileagePolicyRepository = $this->createMock(MileagePolicyRepository::class);
        $this->showRateQueryHandler = new EditRateQueryHandler($this->rateRepository, $this->delegationRepository, $this->fuelPolicyRepository, $this->mileagePolicyRepository);
    }

    /**
     * @test
     */
    public function should_return_show_rate_response_object()
    {
        $query = new EditRateQuery(1);

        $this->rateRepository->method("getById")->willReturn(
            new Rate(1, "Tarifa 1", 1, 1, 1)
        );
        $this->delegationRepository->method("getById")->willReturn(
            new Delegation(1, "Mallorca")
        );
        $this->fuelPolicyRepository->method("getById")->willReturn(
            new FuelPolicy(1, "Full Full")
        );
        $this->mileagePolicyRepository->method("getById")->willReturn(
            new MileagePolicy(1, "Limited")
        );

        $response =  $this->showRateQueryHandler->handle($query);

        $this->assertInstanceOf(EditRateResponse::class, $response);
        $this->assertEquals(1 , $response->getRateId());
        $this->assertEquals("Tarifa 1" , $response->getRateName());
        $this->assertEquals(1 , $response->getRateDelegationId());
        $this->assertEquals("Mallorca" , $response->getRateDelegationName());
        $this->assertEquals(1 , $response->getRateFuelPolicyCode());
        $this->assertEquals("Full Full" , $response->getRateFuelPolicyName());
        $this->assertEquals(1 , $response->getRateMileagePolicyCode());
        $this->assertEquals("Limited" , $response->getRateMileagePolicyName());
    }
}