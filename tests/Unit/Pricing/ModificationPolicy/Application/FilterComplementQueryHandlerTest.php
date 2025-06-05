<?php


namespace App\Tests\Unit\Pricing\ModificationPolicy\Application;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pricing\Complement\Application\ComplementCreator;
use Pricing\Complement\Domain\Acriss;
use Pricing\Complement\Domain\AcrissCollection;
use Pricing\Complement\Domain\AutomaticComplement\Age;
use Pricing\Complement\Domain\AutomaticComplement\AgeRules;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticCoverageComplement;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticCoverageComplementCollection;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticFeeComplement;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticFeeComplementCollection;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticItemComplement;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticItemComplementCollection;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticServiceComplement;
use Pricing\Complement\Domain\AutomaticComplement\AutomaticServiceComplementCollection;
use Pricing\Complement\Domain\AutomaticComplement\CarType;
use Pricing\Complement\Domain\AutomaticComplement\DifferentDriver;
use Pricing\Complement\Domain\AutomaticComplement\DropOff;
use Pricing\Complement\Domain\AutomaticComplement\DropoffRules;
use Pricing\Complement\Domain\AutomaticComplement\EarlyBooking;
use Pricing\Complement\Domain\AutomaticComplement\EarlyDropOff;
use Pricing\Complement\Domain\AutomaticComplement\LateDropOff;
use Pricing\Complement\Domain\AutomaticComplement\Pickup;
use Pricing\Complement\Domain\AutomaticComplement\PickupRules;
use Pricing\Complement\Domain\Carclass;
use Pricing\Complement\Domain\CarclassCollection;
use Pricing\Complement\Domain\Complement;
use Pricing\Complement\Domain\ComplementCategory;
use Pricing\Complement\Domain\ComplementCollection;
use Pricing\Complement\Domain\ArticleGroup;
use Pricing\Complement\Domain\ComplementGetByResponse;
use Pricing\Complement\Domain\ComplementRate;
use Pricing\Complement\Domain\ComplementRateCollection;
use Pricing\Complement\Domain\ComplementRateType;
use Pricing\Complement\Domain\ComplementRelated;
use Pricing\Complement\Domain\ComplementRelatedCollection;
use Pricing\Complement\Domain\ComplementRepository;
use Pricing\Complement\Domain\ComplementArticle;
use Pricing\Complement\Domain\Delegation;
use Pricing\Complement\Domain\Excess;
use Pricing\Complement\Domain\ExcessTypeOption;
use Pricing\Complement\Domain\MaxBooking;
use Pricing\Complement\Domain\MaxBookingTypeOption;
use Pricing\Complement\Domain\MileageLimit;
use Pricing\Complement\Domain\MileageRevisionOption;
use Pricing\Complement\Domain\Preauthorization;
use Pricing\Complement\Domain\PreauthorizationTypeOption;
use Pricing\ComplementCategory\Infrastructure\ComplementCategoryRepositoryFake;
use Pricing\ComplementRate\Domain\ComplementRateCriteria;
use Pricing\ComplementRate\Infrastructure\ComplementRateRepositoryFake;
use Pricing\ComplementRateType\Infrastructure\ComplementRateTypeRepositoryFake;
use Pricing\ComplementType\Infrastructure\ComplementArticleRepositoryFake;
use Pricing\Delegation\Infrastructure\DelegationRepositoryFake;
use Pricing\ModificationPolicy\Application\FilterComplement\FilterComplementQuery;
use Pricing\ModificationPolicy\Application\FilterComplement\FilterComplementQueryHandler;
use Pricing\ModificationPolicy\Application\FilterComplement\FilterComplementResponse;
use Pricing\Revenue\Domain\Revenue;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;
use Shared\Domain\ValueObject\AgeValueObject;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Domain\ValueObject\DropoffValueObject;
use Shared\Domain\ValueObject\PickupValueObject;


class FilterComplementQueryHandlerTest extends TestCase
{
    /**
     * @var MockObject|ComplementRepository
     */
    private $complementRepository;

    /**
     * @var FilterComplementQueryHandler
     */
    private $filterComplementQueryHandler;

    public function setUp()
    {
        $this->complementRepository = $this->createMock(ComplementRepository::class);
        $this->filterComplementQueryHandler = new FilterComplementQueryHandler($this->complementRepository);
    }
    /**
     * @test
     */
    public function should_return_filter_complement_response_object()
    {
        $objectArray = [];
        $complementCategoryId = 0;
        $complementTypeId = 0;
        $complementRateTypeId = 0;
        $deskAux = 0;
        $totemAux = 0;
        $dailyExtraKm = null;

        $complementRateRepositoryFake = new ComplementRateRepositoryFake();
        $complementCategoryRepositoryFake = new ComplementCategoryRepositoryFake();
        $complementTypeRepositoryFake = new ComplementArticleRepositoryFake();

        $delegationRepositoryFake = new DelegationRepositoryFake();
        $delegationList = $delegationRepositoryFake->delegations;

        //ComplementRateType
        $complementRateTypeRepositoryFake = new ComplementRateTypeRepositoryFake();
        $complementRateType = $complementRateTypeRepositoryFake->complementRateTypes;

        for($complementId = 1; $complementId < 7; $complementId++){
            //TODO Crear enum de las categorias, y sacar el maximo de ese enum
            $complementCategoryId = ($complementCategoryId % 8 == 0) ? 1 : $complementCategoryId+1;
            //TODO Revisar esto
            $complementTypeId = ($complementTypeId % 40 == 0) ? 1 : $complementTypeId+1;
            $incentivable = ($complementId % 2 == 0) ? true : false;
            $editable = ($complementId % 2 == 0) ? true : false;
            $inactive = false;
            $deskAux = ($deskAux % 6 == 0) ? 1 : $deskAux+1;
            $desk = ($deskAux <= 3) ? true : false;
            $totemAux = ($totemAux % 5 == 0) ? 1 : $totemAux+1;
            $totem = ($totemAux <= 3) ? true : false;
            $complementRateCollection = null;

            $maxBooking = new maxBooking(new MaxBookingTypeOption(MaxBookingTypeOption::NONE),null,null,null);
            $preauthItem = null;

            $automaticItemComplementCollection = null;
            $automaticServiceComplementCollection = null;
            $automaticCoverageComplementCollection = null;
            $automaticFeeComplementCollection = null;
            //TODO EN funcion de la categoria, iterar entre las posibles tipos de tarifa de cada categoria.
            $complementRateCode = [1,2,3,4,5];

            $excludedFeeComplementCollection = ($complementCategoryId == Complement::COMPLEMENT_COVERAGE) ? new ComplementRelatedCollection([
                new ComplementRelated(5, "Nombre interno 5"),
                new ComplementRelated(13, "Nombre interno 13"),
                new ComplementRelated(21, "Nombre interno 21")
            ]) : null;

            $packageComplementCollection = ($complementCategoryId == Complement::COMPLEMENT_PACKAGE) ? new ComplementRelatedCollection([
                new ComplementRelated(6, "Nombre interno 6"),
                new ComplementRelated(14, "Nombre interno 14")
            ]) : null;

            if($complementCategoryId == Complement::COMPLEMENT_COMBUSTIBLE) {
                $complementRateCode = [5, 10];
            }

            if($complementCategoryId == Complement::COMPLEMENT_MILEAGE){
                $dailyExtraKm = 35;
            }

            if($complementCategoryId == Complement::COMPLEMENT_ITEM) {
                $delegationIndex = $delegationRepositoryFake->getIndex(1);

                $age = null;
                $earlyBooking = new EarlyBooking(
                    0,
                    120
                );
                $pickup = new Pickup(
                    0,
                    new PickupRules(new PickupValueObject(240),new PickupValueObject(560))
                );
                $dropOff = new DropOff(
                    1,
                    new DropoffRules(new DropoffValueObject(220),new DropoffValueObject(520))
                );
                $automaticItemComplementArray = [];
                $automaticItemComplementArray[] = new AutomaticItemComplement(
                    $age,
                    $earlyBooking,
                    $pickup,
                    $dropOff,
                    new Delegation($delegationList[$delegationIndex]['id'],$delegationList[$delegationIndex]['name'])
                );
                $automaticItemComplementCollection = new AutomaticItemComplementCollection($automaticItemComplementArray);
            }
            if($complementCategoryId == Complement::COMPLEMENT_SERVICE) {

                $earlyPickup= 120;
                $latePickup = 60;

                $delegationIndex = $delegationRepositoryFake->getIndex(2);
                $automaticServiceComplementArray = [];
                $automaticServiceComplementArray[] = new AutomaticServiceComplement(
                    new Age(
                        1,
                        new AgeRules(new AgeValueObject(18),new AgeValueObject(22))
                    ),
                    new EarlyBooking(
                        0,
                        120
                    ),
                    $earlyPickup,
                    $latePickup,
                    new DifferentDriver(
                        0,
                        1
                    ),
                    new Delegation($delegationList[$delegationIndex]['id'],$delegationList[$delegationIndex]['name'])
                );
                $automaticServiceComplementCollection = new AutomaticServiceComplementCollection($automaticServiceComplementArray);

            }
            if($complementCategoryId == Complement::COMPLEMENT_COVERAGE) {
                $delegationIndex = $delegationRepositoryFake->getIndex(1);
                $automaticCoverageComplementArray = [];
                $automaticCoverageComplementArray[] = new AutomaticCoverageComplement(
                    new Age(
                        1,
                        new AgeRules(new AgeValueObject(18),new AgeValueObject(22))
                    ),
                    new DifferentDriver(
                        0,
                        1
                    ),
                    new CarType(
                        0,
                        2,
                        null,
                        new CarclassCollection([
                            new Carclass(1, 'Mini'),
                            new Carclass(5, 'Plus'),
                            new Carclass(7, 'Silver')
                        ])
                    ),
                    new Delegation($delegationList[$delegationIndex]['id'],$delegationList[$delegationIndex]['name'])
                );
                $automaticCoverageComplementArray[] = new AutomaticCoverageComplement(
                    new Age(
                        1,
                        new AgeRules(new AgeValueObject(18),new AgeValueObject(22))
                    ),
                    new DifferentDriver(
                        0,
                        1
                    ),
                    new CarType(
                        0,
                        1,
                        new AcrissCollection([
                            new Acriss(1,"MBRM"),
                            new Acriss(2,"ACDR"),
                            new Acriss(6,"ZBRM"),
                            new Acriss(7,"ZCDR")
                        ]),
                        null
                    ),
                    new Delegation($delegationList[$delegationIndex]['id'],$delegationList[$delegationIndex]['name'])
                );
                $automaticCoverageComplementCollection = new AutomaticCoverageComplementCollection($automaticCoverageComplementArray);
            }
            if($complementCategoryId == Complement::COMPLEMENT_FEE) {
                $delegationIndex = $delegationRepositoryFake->getIndex(3);
                $conditionsFeeComplementArray = [];
                $conditionsFeeComplementArray[] = new AutomaticFeeComplement(
                    false,
                    new EarlyDropOff(null, 15),
                    new LateDropOff(null, 60),
                    new Delegation($delegationList[$delegationIndex]['id'],$delegationList[$delegationIndex]['name']),
                    true
                );
                $automaticFeeComplementCollection = new AutomaticFeeComplementCollection($conditionsFeeComplementArray);
            }
            if($complementCategoryId == Complement::COMPLEMENT_PACKAGE){
                $complementRateCode = null;
            }

            $preauthorization = new Preauthorization(
                new PreauthorizationTypeOption(PreauthorizationTypeOption::ALL),
                10,
                null,
                null
            );
            $excess =  new Excess(
                new ExcessTypeOption(ExcessTypeOption::ALL),
                20,
                null,
                null
            );

            $mileageLimit = new MileageLimit(new MileageRevisionOption(1),1250);
            $variationPercentage = 10;

            //ComplementCategory
            $complementCategory = $complementCategoryRepositoryFake->complementCategory;
            $complementCategoryIndex = $complementCategoryRepositoryFake->getIndex($complementCategoryId);

            if(!is_null($complementRateCode)){
                //ComplementRate

                $complementRateData = $complementRateRepositoryFake->getBy(new ComplementRateCriteria(new FilterCollection([new Filter('code',new FilterOperator(FilterOperator::IN), $complementRateCode)])))->getCollection();

                $complementRateCollection = new ComplementRateCollection([]);
                foreach ($complementRateData as $complementRate){
                    $delegationIndex = $delegationRepositoryFake->getIndex($complementRate->getDelegationPickup()->getId());
                    $complementRateCollection->add(new ComplementRate($complementRate->getCode(), $complementRate->getName(), new Delegation($delegationList[$delegationIndex]['id'], $delegationList[$delegationIndex]['name'])));
                }

            }

            //ComplementArticle
            $complementTypeId = ($complementTypeId % 5 == 0) ? 1 : $complementTypeId+1;
            $complementType = $complementTypeRepositoryFake->getById($complementTypeId);

            //ArticleGroup
            $articleGroupId = $complementType->getComplementFamily()->getId();
            $articleGroupInternalName = $complementType->getComplementFamily()->getInternalName();

            $complementRateTypeId = ($complementRateTypeId % 5 == 0) ? 1 : $complementRateTypeId+1;
            $complementRateTypeIndex = array_search($complementRateTypeId, array_column($complementRateType,'id'));

            $complements[] = ComplementCreator::create(
                $complementId,
                "CODE".$complementId,
                $complementId,
                new ComplementCategory($complementCategory[$complementCategoryIndex]['id'], $complementCategory[$complementCategoryIndex]['name']),
                new DateTimeValueObject(new \DateTime("2020-12-21 20:45:00")),
                "Nombre interno ".$complementId,
                "Descripcion ".$complementId,
                "",
                new ComplementArticle($complementType->getId(), $complementType->getInternalName(), new ArticleGroup($articleGroupId, $articleGroupInternalName), true, new Revenue($complementId,'revenue '.$complementId), new ComplementRateType($complementRateTypeId, $complementRateType[$complementRateTypeIndex]['name'])),
                $incentivable,
                $editable,
                $inactive,
                "WSCODE".$complementId,
                $desk,
                $totem,
                $maxBooking,
                $excludedFeeComplementCollection,
                $packageComplementCollection,
                $automaticItemComplementCollection,
                $automaticServiceComplementCollection,
                $automaticFeeComplementCollection,
                $automaticCoverageComplementCollection,
                $preauthorization,
                $excess,
                $preauthItem,
                $complementRateCollection,
                $variationPercentage,
                $mileageLimit,
                $dailyExtraKm
            );
        }
        $complementCollection = new ComplementCollection($complements);

        $this->complementRepository->method("getBy")->willReturn(
            new ComplementGetByResponse(
                $complementCollection,
                $complementCollection->count())
        );

        $complementList = array();

        foreach ($complementCollection as $complement){
            $complementList[] = [
                'code' => $complement->getCode(),
                'codeName' => $complement->getCodeName(),
                'internalName' => $complement->getInternalName(),
            ];
        }

        $complementResponse = [
            'total' => $complementCollection->count(),
            'rows' => $complementList,
            'totalNotFiltered' => 100
        ];

        $response = $this->filterComplementQueryHandler->handle(
            new FilterComplementQuery(
                null,
                null,
                1,
                null,
                null
            )
        );
        $this->assertInstanceOf(FilterComplementResponse::class, $response);
        $this->assertEquals($complementResponse, $response->getFilterComplementResponse());
    }
}