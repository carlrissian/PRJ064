<?php


namespace App\Tests\Unit\Pricing\ModificationPolicy\Application;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pricing\ModificationPolicy\Application\FilterModificationPolicy\FilterModificationPolicyQuery;
use Pricing\ModificationPolicy\Application\FilterModificationPolicy\FilterModificationPolicyQueryHandler;
use Pricing\ModificationPolicy\Application\FilterModificationPolicy\FilterModificationPolicyResponse;
use Pricing\ModificationPolicy\Domain\CheckComplement;
use Pricing\ModificationPolicy\Domain\Complement;
use Pricing\ModificationPolicy\Domain\ModificationPolicy;
use Pricing\ModificationPolicy\Domain\ModificationPolicyCollection;
use Pricing\ModificationPolicy\Domain\ModificationPolicyGetByResponse;
use Pricing\ModificationPolicy\Domain\ModificationPolicyRepository;

class FilterModificationPolicyQueryHandlerTest extends TestCase
{
    /**
     * @var MockObject|ModificationPolicyRepository
     */
    private $modificationPolicyRepository;

    /**
     * @var FilterModificationPolicyQueryHandler
     */
    private $filterModificationPolicyQueryHandler;

    public function setUp()
    {
        $this->modificationPolicyRepository = $this->createMock(ModificationPolicyRepository::class);
        $this->filterModificationPolicyQueryHandler = new FilterModificationPolicyQueryHandler($this->modificationPolicyRepository);
    }

    /**
     * @test
     * @throws \Pricing\ModificationPolicy\Domain\CheckComplementInvalidArgumentException
     */
    public function should_return_filter_monthly_summary_response_object()
    {
        $modificationPolicy = [];
        for($x = 1; $x <=50; $x++){
            $modificationPolicy[] = new ModificationPolicy(
                $x,
                1,
                "Modificación ".$x,
                "Descripción modificación ".$x,
                "Notes modificación".$x,
                new CheckComplement(true,new Complement(2, "Complement 2")),
                new CheckComplement(false,null),
                new CheckComplement(true,new Complement(21, "Complement 21")),
                new CheckComplement(true,new Complement(10, "Complement 10")),
                new CheckComplement(false,null),
                new CheckComplement(false,null),
                new CheckComplement(true,null),
                new CheckComplement(false,null),
                new CheckComplement(false,null),
                new CheckComplement(true,new Complement(17, "Complement 17")),
                new CheckComplement(true,new Complement(27, "Complement 27")),
                new CheckComplement(true,new Complement(36, "Complement 36")),
                new CheckComplement(false,null),
                new CheckComplement(true,new Complement(19, "Complement 19")),
                new CheckComplement(true,new Complement(43, "Complement 43")),
                new CheckComplement(false,null)
            );
        }

        $modificationPolicyCollection = new ModificationPolicyCollection($modificationPolicy);

        $this->modificationPolicyRepository->method("getBy")->willReturn(
            new ModificationPolicyGetByResponse(
                $modificationPolicyCollection,
                $modificationPolicyCollection->count())
        );

        $modificationPolicyList = array();

        foreach ($modificationPolicyCollection as $modificationPolicy){

            $modificationPolicyList[] = [
                'id' => $modificationPolicy->getId(),
                'version' => $modificationPolicy->getVersion(),
                'internalName' => $modificationPolicy->getInternalName(),
                'description' => $modificationPolicy->getDescription()
            ];
        }

        $modificationPolicyResponse = [
            'total' => $modificationPolicyCollection->count(),
            'rows' => $modificationPolicyList,
            'totalNotFiltered' => 100
        ];

        $response = $this->filterModificationPolicyQueryHandler->handle(
            new FilterModificationPolicyQuery(
                null,
                null,
                null,
                null,
                null
            )
        );
        $this->assertInstanceOf(FilterModificationPolicyResponse::class, $response);
        $this->assertEquals($modificationPolicyResponse, $response->getFilterModificationPolicyResponse());
    }
}