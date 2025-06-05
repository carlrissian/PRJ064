<?php


namespace App\Tests\Unit\Pricing\Family\Application\CreateFamily;


use PHPUnit\Framework\TestCase;

use Pricing\ComplementCategory\Domain\ComplementCategory;
use Pricing\ComplementCategory\Domain\ComplementCategoryCollection;
use Pricing\ComplementCategory\Domain\ComplementCategoryRepository;
use Pricing\Family\Application\CreateFamily\CreateComplementFamilyQuery;
use Pricing\Family\Application\CreateFamily\CreateComplementFamilyQueryHandler;
use Pricing\Family\Application\CreateFamily\CreateComplementFamilyResponse;


class CreateFamilyQueryHandlerTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject | ComplementCategoryRepository
     */
    private $complementCategoryRepository;
    /**
     * @var CreateComplementFamilyQueryHandler
     */
    private $createFamilyQueryHandler;

    protected function setUp()
    {
        $this->complementCategoryRepository = $this->createMock(ComplementCategoryRepository::class);
        $this->createFamilyQueryHandler = new CreateComplementFamilyQueryHandler($this->complementCategoryRepository);
    }

    /**
     * @test
     */
    public function should_return_list_complement_category_response_array()
    {

        $this->complementCategoryRepository->method("getAll")
            ->willReturn(new ComplementCategoryCollection([
                    new ComplementCategory(1, "Accesorio"),
                    new ComplementCategory(2, "Servicio"),
                    new ComplementCategory(3, "Cobertura"),
                    new ComplementCategory(4, "Kilometraje"),
                    new ComplementCategory(5, "Fee"),
                    new ComplementCategory(6, "Paquete"),
                    new ComplementCategory(7, "Combustible"),
                ])
            );

        $response = $this->createFamilyQueryHandler->handler(new CreateComplementFamilyQuery());
        $this->assertInstanceOf(CreateComplementFamilyResponse::class,$response);

        $this->assertEquals(
            $response->getComplementCategoryArray(),
            [
                ["id" => 1, "name" => "Accesorio"],
                ["id" => 2, "name" => "Servicio"],
                ["id" => 3, "name" => "Cobertura"],
                ["id" => 4, "name" => "Kilometraje"],
                ["id" => 5, "name" => "Fee"],
                ["id" => 6, "name" => "Paquete"],
                ["id" => 7, "name" => "Combustible"]
            ]
        );
    }

}