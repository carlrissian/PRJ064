<?php


namespace App\Tests\Unit\Pricing\ModificationPolicy\Application;

use Financiero\MonthlySummary\Application\ShowMonthlySummary\ShowMonthlySummaryQuery;
use Financiero\MonthlySummary\Application\ShowMonthlySummary\ShowMonthlySummaryQueryResponse;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pricing\ModificationPolicy\Application\ShowModificationPolicy\ShowModificationPolicyQuery;
use Pricing\ModificationPolicy\Application\ShowModificationPolicy\ShowModificationPolicyQueryHandler;
use Pricing\ModificationPolicy\Application\ShowModificationPolicy\ShowModificationPolicyResponse;
use Pricing\ModificationPolicy\Domain\CheckComplement;
use Pricing\ModificationPolicy\Domain\CheckComplementInvalidArgumentException;
use Pricing\ModificationPolicy\Domain\Complement;
use Pricing\ModificationPolicy\Domain\ModificationPolicy;
use Pricing\ModificationPolicy\Domain\ModificationPolicyRepository;

class ShowModificationPolicyQueryHandlerTest extends TestCase
{
    /**
     * @var MockObject|ModificationPolicyRepository
     */
    private $modificationPolicyRepository;

    /**
     * @var ShowModificationPolicyQueryHandler
     */
    private $showModificationPolicyQueryHandler;

    public function setUp()
    {
        $this->modificationPolicyRepository = $this->createMock(ModificationPolicyRepository::class);
        $this->showModificationPolicyQueryHandler = new ShowModificationPolicyQueryHandler($this->modificationPolicyRepository);
    }

    /**
     * @test
     * @throws CheckComplementInvalidArgumentException
     */
    public function should_return_show_modification_policy_response_object()
    {
        $modificationPolicy = new ModificationPolicy(
            1,
            1,
            "Política de modificación 1",
            "Descripción 1",
            null,
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

        $this->modificationPolicyRepository->method("getById")->willReturn($modificationPolicy);

        $response = $this->showModificationPolicyQueryHandler->handle(
            new ShowModificationPolicyQuery(
                1
            )
        );

        $this->assertInstanceOf(ShowModificationPolicyResponse::class, $response);
        $this->assertEquals($modificationPolicy, $response->getModificationPolicy());
    }
}