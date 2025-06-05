<?php


namespace App\Tests\Unit\Pricing\FuelPolicy\Application\ShowFuelPolicy;


use PHPUnit\Framework\TestCase;
use Pricing\Complement\Application\ComplementCreator;
use Pricing\Complement\Domain\ComplementCollection;
use Pricing\Complement\Domain\ComplementRepository;
use Pricing\FuelPolicy\Application\ShowFuelPolicy\ShowFuelPolicyQuery;
use Pricing\FuelPolicy\Application\ShowFuelPolicy\ShowFuelPolicyQueryHandler;
use Pricing\FuelPolicy\Application\ShowFuelPolicy\ShowFuelPolicyResponse;
use Pricing\FuelPolicy\Domain\FuelPolicy;
use Pricing\FuelPolicy\Domain\FuelPolicyRepository;

class ShowFuelPolicyQueryHandlerTest extends TestCase
{
    /**
     * @var FuelPolicyRepository
     */
    private $fuelPolicyRepository;
    /**
     * @var ComplementRepository
     */
    private $complementRepository;
    /**
     * @var ShowFuelPolicyQueryHandler
     */
    private $showFuelPolicyQueryHandler;
    protected function setUp()
    {
        $this->complementRepository = $this->createMock(ComplementRepository::class);
        $this->fuelPolicyRepository = $this->createMock(FuelPolicyRepository::class);
        $this->showFuelPolicyQueryHandler = new ShowFuelPolicyQueryHandler($this->fuelPolicyRepository,$this->complementRepository);
    }

    /**
     * @test
     */
    public function should_return_show_fuelPolicy_response()
    {
        $this->fuelPolicyRepository->method("getById")
            ->will($this->returnValueMap([
                [1, new FuelPolicy(1, 2, "10/11/2019","Full Full","This is a description", "Esto son notas",[1,3,5,7])],
                [2, new FuelPolicy(2, 5, "11/11/2019","Full Empty","This is a description 2", "Esto son notas 2",[1,2,4,6])],
                [3, new FuelPolicy(3, 6, "12/11/2019","Empty Full","This is a description 3", "Esto son notas 3",[1,4,5,7])],
                [4, new FuelPolicy(4, 3, "13/11/2019","Empty Empty","This is a description 4", "Esto son notas 4",[1,6,7,8])],
            ]));
        $this->complementRepository->method("getByTypes")
            ->will($this->returnValueMap(
                [
                    [[7],
                        new ComplementCollection(
                            [
                                ComplementCreator::create(1,3,7,"01/06/1980 23:43:19","alias 1","enim 1","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",2,false,true,true,3,false,null,null,null,null,null,null,null,true),
                                ComplementCreator::create(2,1,7,"02/06/1980 23:43:19","alias 2","enim 2","Repudiandae officiis assumenda iure ut cum architecto. 2", "Magnam beatae omnis qui ut. 2",2,false,true,true,3,false,null,null,null,null,null,null,null,true),
                                ComplementCreator::create(3,5,7,"03/06/1980 23:43:19","alias 3","enim 3","Repudiandae officiis assumenda iure ut cum architecto. 3", "Magnam beatae omnis qui ut. 3",1,false,true,true,3,false,null,null,null,null,null,null,null,true),
                                ComplementCreator::create(4,1,7,"04/06/1980 23:43:19","alias 4","enim 4","Repudiandae officiis assumenda iure ut cum architecto. 4", "Magnam beatae omnis qui ut. 4",1,false,true,true,3,false,null,null,null,null,null,null,null,false),
                                ComplementCreator::create(5,2,7,"05/06/1980 23:43:19","alias 5","enim 5","Repudiandae officiis assumenda iure ut cum architecto. 5", "Magnam beatae omnis qui ut. 5",1,false,true,true,3,false,null,null,null,null,null,null,null,true),
                                ComplementCreator::create(6,4,7,"06/06/1980 23:43:19","alias 6","enim 6","Repudiandae officiis assumenda iure ut cum architecto. 6", "Magnam beatae omnis qui ut. 6",2,false,true,true,3,false,null,null,null,null,null,null,null,false),
                                ComplementCreator::create(7,3,7,"07/06/1980 23:43:19","alias 7","enim 7","Repudiandae officiis assumenda iure ut cum architecto. 7", "Magnam beatae omnis qui ut. 7",1,false,true,true,3,false,null,null,null,null,null,null,null,true),
                                ComplementCreator::create(8,1,7,"08/06/1980 23:43:19","alias 8","enim 8","Repudiandae officiis assumenda iure ut cum architecto. 8", "Magnam beatae omnis qui ut. 8",1,false,true,true,3,false,null,null,null,null,null,null,null,true)
                            ])
                    ]
                ]
            ));
        $response = $this->showFuelPolicyQueryHandler->handler(new ShowFuelPolicyQuery(2));
        $this->assertInstanceOf(ShowFuelPolicyResponse::class,$response);

        $this->assertEquals(2, $response->getId());
        $this->assertEquals(5, $response->getVersion());
        $this->assertEquals("11/11/2019", $response->getCreationDate());
        $this->assertEquals("Full Empty", $response->getInternalName());
        $this->assertEquals("This is a description 2", $response->getDescription());
        $this->assertEquals("Esto son notas 2", $response->getNotes());
        $this->assertEquals(["enim 1","enim 2","enim 4","enim 6"], $response->getComplementInternalNameArray());

    }
}