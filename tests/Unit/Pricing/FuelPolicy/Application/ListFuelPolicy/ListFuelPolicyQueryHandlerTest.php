<?php


namespace App\Tests\Unit\Pricing\FuelPolicy\Application\ListFuelPolicy;


use PHPUnit\Framework\TestCase;
use Pricing\Complement\Application\ComplementCreator;
use Pricing\Complement\Domain\ComplementCollection;
use Pricing\Complement\Domain\ComplementRepository;
use Pricing\Family\Domain\ComplementFamily;
use Pricing\Family\Domain\ComplementFamilyCollection;
use Pricing\Family\Domain\ComplementFamilyRepository;
use Pricing\ComplementArticle\Domain\ComplementArticle;
use Pricing\ComplementArticle\Domain\ComplementArticleCollection;
use Pricing\ComplementArticle\Domain\ComplementArticleRepository;
use Pricing\FuelPolicy\Application\ListFuelPolicy\ListFuelPolicyQuery;
use Pricing\FuelPolicy\Application\ListFuelPolicy\ListFuelPolicyQueryHandler;
use Pricing\FuelPolicy\Application\ListFuelPolicy\ListFuelPolicyResponse;
use Pricing\FuelPolicy\Domain\FuelPolicy;
use Pricing\FuelPolicy\Domain\FuelPolicyCollection;
use Pricing\FuelPolicy\Domain\FuelPolicyRepository;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ListFuelPolicyQueryHandlerTest extends TestCase
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
     * @var ComplementArticleRepository
     */
    private $complementArticleRepository;
    /**
     * @var ComplementFamilyRepository
     */
    private $articleGroupRepository;
    /**
     * @var ListFuelPolicyQueryHandler
     */
    private $listFuelPolicyQueryHandler;

    protected function setUp()
    {
        $this->fuelPolicyRepository = $this->createMock(FuelPolicyRepository::class);
        $this->complementRepository = $this->createMock(ComplementRepository::class);
        $this->complementArticleRepository = $this->createMock(ComplementArticleRepository::class);
        $this->articleGroupRepository = $this->createMock(ComplementFamilyRepository::class);
        $this->listFuelPolicyQueryHandler = new ListFuelPolicyQueryHandler(new Serializer([], [new JsonEncoder()]),$this->fuelPolicyRepository, $this->complementRepository,$this->complementArticleRepository,$this->articleGroupRepository);
    }
    /**
     * @test
     */
    public function should_return_list_fuelPolicy_response()
    {
        $this->fuelPolicyRepository->method("getAll")->willReturn(
            new FuelPolicyCollection([
                new FuelPolicy(1, 2, "10/11/2019","Full Full","This is a description", "Esto son notas",[1,3,5,7]),
                new FuelPolicy(2, 5, "11/11/2019","Full Empty","This is a description 2", "Esto son notas 2",[1,2,4,6]),
                new FuelPolicy(3, 6, "12/11/2019","Empty Full","This is a description 3", "Esto son notas 3",[1,4,5,7]),
                new FuelPolicy(4, 3, "13/11/2019","Empty Empty","This is a description 4", "Esto son notas 4",[1,6,7,8]),
            ])
        );
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
        $this->complementArticleRepository->method("getAll")->willReturn(
            new ComplementArticleCollection([
                new ComplementArticle(1, "GoPad", "GP",1,7),
                new ComplementArticle(2, "Conductor Adicional", "AD",4,5),
                new ComplementArticle(3, "Sillita de bebe", "SB",3,4),
            ])
        );
        $this->articleGroupRepository->method("getAll")->willReturn(
            new ComplementFamilyCollection([
                new ComplementFamily(1, "Familia 1", 2),
                new ComplementFamily(2, "Familia 2", 3),
                new ComplementFamily(3, "Familia 3", 1),
                new ComplementFamily(4, "Familia 4", 5),
                new ComplementFamily(5, "Familia 5", 4),
                new ComplementFamily(6, "Familia 6", 7),
                new ComplementFamily(7, "Familia 7", 6),
            ])
        );

        $response = $this->listFuelPolicyQueryHandler->handler(new ListFuelPolicyQuery());
        $this->assertInstanceOf(ListFuelPolicyResponse::class,$response);

        $this->assertEquals($response->getFamilyArray(),
            [
                ["id" => 1, "name" => "Familia 1"],
                ["id" => 2, "name" => "Familia 2"],
                ["id" => 3, "name" => "Familia 3"],
                ["id" => 4, "name" => "Familia 4"],
                ["id" => 5, "name" => "Familia 5"],
                ["id" => 6, "name" => "Familia 6"],
                ["id" => 7, "name" => "Familia 7"]
            ]
        );
        $this->assertEquals($response->getComplementArticleArray(),
            [
                ["id" => 1, "name" => "GoPad"],
                ["id" => 2, "name" => "Conductor Adicional"],
                ["id" => 3, "name" => "Sillita de bebe"]
            ]
        );
        $this->assertEquals($response->getFuelPolicyArray(),
            '[{"id":1,"version":2,"internalName":"Full Full","description":"This is a description","type":"Conductor AdicionalGoPadGoPadGoPad","family":"Familia 5Familia 7Familia 7Familia 7"},{"id":2,"version":5,"internalName":"Full Empty","description":"This is a description 2","type":"Conductor AdicionalConductor AdicionalGoPadConductor Adicional","family":"Familia 5Familia 5Familia 7Familia 5"},{"id":3,"version":6,"internalName":"Empty Full","description":"This is a description 3","type":"Conductor AdicionalGoPadGoPadGoPad","family":"Familia 5Familia 7Familia 7Familia 7"},{"id":4,"version":3,"internalName":"Empty Empty","description":"This is a description 4","type":"Conductor AdicionalConductor AdicionalGoPadGoPad","family":"Familia 5Familia 5Familia 7Familia 7"}]'
        );

    }
    /**
     * @test
     */
    public function should_return_a_FuelPolicyNotFoundException_response(){
        $this->fuelPolicyRepository->method("getAll")->willReturn(
            new FuelPolicyCollection([
            ])
        );

    }
}