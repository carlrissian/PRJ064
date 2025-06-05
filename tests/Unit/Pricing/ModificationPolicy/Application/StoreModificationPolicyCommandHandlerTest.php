<?php


namespace App\Tests\Unit\Pricing\ModificationPolicy\Application;


use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Pricing\ModificationPolicy\Application\StoreModificationPolicy\StoreModificationPolicyCommand;
use Pricing\ModificationPolicy\Application\StoreModificationPolicy\StoreModificationPolicyCommandHandler;
use Pricing\ModificationPolicy\Application\StoreModificationPolicy\StoreModificationPolicyResponse;
use Pricing\ModificationPolicy\Domain\CheckComplement;
use Pricing\ModificationPolicy\Domain\Complement;
use Pricing\ModificationPolicy\Domain\ModificationPolicy;
use Pricing\ModificationPolicy\Domain\ModificationPolicyRepository;

class StoreModificationPolicyCommandHandlerTest extends TestCase
{
    /**
     * @var MockObject|ModificationPolicyRepository
     */
    private $modificationPolicyRepository;

    /**
     * @var StoreModificationPolicyCommandHandler
     */
    private $storeModificationPolicyCommandHandler;

    public function setUp()
    {
        $this->modificationPolicyRepository = $this->createMock(ModificationPolicyRepository::class);
        $this->storeModificationPolicyCommandHandler = new StoreModificationPolicyCommandHandler($this->modificationPolicyRepository);
    }

    /**
     * @test
     * @throws \Pricing\ModificationPolicy\Domain\CheckComplementInvalidArgumentException
     */
    public function should_return_store_modification_policy_response()
    {
        $this->modificationPolicyRepository->method('store')
            ->willReturn(new ModificationPolicy(
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
            ));

        $response = $this->storeModificationPolicyCommandHandler->handle(new StoreModificationPolicyCommand(
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
        ));

        $this->assertInstanceOf(StoreModificationPolicyResponse::class,$response);

        $this->assertEquals($response->getId(),1);
    }
}