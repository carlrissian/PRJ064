<?php


namespace App\Tests\Unit\Pricing\Product\Application;


use PHPUnit\Framework\TestCase;
use Pricing\Complement\Application\ComplementCreator;
use Pricing\Complement\Domain\ComplementCollection;
use Pricing\Complement\Domain\ComplementRepository;
use Pricing\Product\Application\CreateProduct\CreateProductQuery;
use Pricing\Product\Application\CreateProduct\CreateProductQueryHandler;
use Pricing\Product\Application\CreateProduct\CreateProductResponse;
use Pricing\Rate\Domain\Rate;
use Pricing\Rate\Domain\RateCollection;
use Pricing\Rate\Domain\RateRepository;

class CreateProductQueryHandlerTest extends TestCase
{
    /**
     * @var ComplementRepository
     */
    private $complementRepository;
    /**
     * @var RateRepository
     */
    private $rateRepository;
    /**
     * @var CreateProductQueryHandler
     */
    private $createProductQueryHandler;

    protected function setUp()
    {
        $this->complementRepository = $this->createMock(ComplementRepository::class);
        $this->rateRepository = $this->createMock(RateRepository::class);
        $this->createProductQueryHandler = new CreateProductQueryHandler($this->complementRepository,$this->rateRepository);
    }

    /**
     * @test
     */
    public function should_return_create_product_response()
    {
        $this->complementRepository->method("getByTypes")
            ->will($this->returnValueMap(
                [
                    [[4], new ComplementCollection(
                        [
                            ComplementCreator::create(1,1,4,"02/05/1980 15:43:19","alias 1","enim 1","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",3,false,true,true,3,false,null,null,null,null,null,null,null,true),
                            ComplementCreator::create(3,1,4,"02/05/1980 15:43:19","alias 3","enim 3","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",3,false,true,true,3,false,null,null,null,null,null,null,null,true),
                            ComplementCreator::create(5,1,4,"02/05/1980 15:43:19","alias 5","enim 5","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",2,false,true,true,3,false,null,null,null,null,null,null,null,false),
                            ComplementCreator::create(7,1,4,"02/05/1980 15:43:19","alias 7","enim 7","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",3,false,true,true,3,false,null,null,null,null,null,null,null,true),
                            ComplementCreator::create(9,1,4,"02/05/1980 15:43:19","alias 9","enim 9","Repudiandae officiis assumenda iure ut cum architecto.", "Magnam beatae omnis qui ut.",2,false,true,true,3,false,null,null,null,null,null,null,null,false),
                        ]
                    )],
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

        $this->rateRepository->method("getAll")
            ->willReturn(new RateCollection([
                    new Rate(1, "Tarifa 1",1,2,1),
                    new Rate(2, "Tarifa 2",2,4,3),
                    new Rate(3, "Tarifa 3",1,6,5),
                    new Rate(4, "Tarifa 4",3,8,7),
                    new Rate(5, "Tarifa 5",2,10,9)
                ])
            );


        $response = $this->createProductQueryHandler->handler(new CreateProductQuery());

        $this->assertInstanceOf(CreateProductResponse::class,$response);

        $this->assertEquals(
            $response->getFuelRateTypeArray(),
            [
                ["id" => 2, "internalName" => "enim 2"],
                ["id" => 4, "internalName" => "enim 4"],
                ["id" => 6, "internalName" => "enim 6"],
                ["id" => 8, "internalName" => "enim 8"],
                ["id" => 10, "internalName" => "enim 10"],
            ]
        );

        $this->assertEquals(
            $response->getComplementKmArray(),
        [
            ["id" => 1, "internalName" => "enim 1"],
            ["id" => 3, "internalName" => "enim 3"],
            ["id" => 5, "internalName" => "enim 5"],
            ["id" => 7, "internalName" => "enim 7"],
            ["id" => 9, "internalName" => "enim 9"],
        ]
        );

        $this->assertEquals(
            $response->getRateArray(),
            [
                ["id" => 1, "name" => "Tarifa 1", "fuelPolicy" => 2, "mileagePolicy" => 1],
                ["id" => 2, "name" => "Tarifa 2", "fuelPolicy" => 4, "mileagePolicy" => 3],
                ["id" => 3, "name" => "Tarifa 3", "fuelPolicy" => 6, "mileagePolicy" => 5],
                ["id" => 4, "name" => "Tarifa 4", "fuelPolicy" => 8, "mileagePolicy" => 7],
                ["id" => 5, "name" => "Tarifa 5", "fuelPolicy" => 10, "mileagePolicy" => 9],
            ]
        );
    }
}