<?php


namespace App\Tests\Unit\Pricing\FuelPolicy\Application\CreateFuelPolicy;


use PHPUnit\Framework\TestCase;
use Pricing\Complement\Application\ComplementCreator;
use Pricing\Complement\Domain\ComplementCollection;
use Pricing\Complement\Domain\ComplementRepository;
use Pricing\FuelPolicy\Application\CreateFuelPolicy\CreateFuelPolicyQuery;
use Pricing\FuelPolicy\Application\CreateFuelPolicy\CreateFuelPolicyQueryHandler;
use Pricing\FuelPolicy\Application\CreateFuelPolicy\CreateFuelPolicyResponse;

class CreateFuelPolicyQueryHandlerTest extends TestCase
{
    /**
     * @var ComplementRepository
     */
    private $complementRepository;
    /**
     * @var CreateFuelPolicyQueryHandlerTest
     */
    private $createFuelPolicyQueryHandler;
    protected function setUp()
    {
        $this->complementRepository = $this->createMock(ComplementRepository::class);
        $this->createFuelPolicyQueryHandler = new CreateFuelPolicyQueryHandler($this->complementRepository);
    }
    /**
     * @test
     */
    public function should_return_create_fuelPolicy_response()
    {
        $this->complementRepository->method("getByTypes")
            ->will($this->returnValueMap(
                [
                    [[7],
                        new ComplementCollection(
                            [
                                ComplementCreator::create(2,1,7,"02/06/1980 23:43:19","alias 2","enim 2","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",2,false,true,true,3,false,null,null,null,null,null,null,null,true),
                                ComplementCreator::create(4,1,7,"02/06/1980 23:43:19","alias 4","enim 4","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",1,false,true,true,3,false,null,null,null,null,null,null,null,false),
                                ComplementCreator::create(6,1,7,"02/06/1980 23:43:19","alias 6","enim 6","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",2,false,true,true,3,false,null,null,null,null,null,null,null,false),
                                ComplementCreator::create(8,1,7,"02/06/1980 23:43:19","alias 8","enim 8","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",1,false,true,true,3,false,null,null,null,null,null,null,null,true),
                                ComplementCreator::create(10,1,7,"02/06/1980 23:43:19","alias 10","enim 10","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",1,false,true,true,3,false,null,null,null,null,null,null,null,true)
                            ])
                    ]
                ]
            ));
        $response = $this->createFuelPolicyQueryHandler->handler(new CreateFuelPolicyQuery());
        $this->assertInstanceOf(CreateFuelPolicyResponse::class,$response);

        $this->assertEquals($response->getDataComplementArray(),
            [
                ["id" => 2, "commercialName" => "alias 2"],
                ["id" => 4, "commercialName" => "alias 4"],
                ["id" => 6, "commercialName" => "alias 6"],
                ["id" => 8, "commercialName" => "alias 8"],
                ["id" => 10, "commercialName" => "alias 10"]
            ]
            );
    }
}