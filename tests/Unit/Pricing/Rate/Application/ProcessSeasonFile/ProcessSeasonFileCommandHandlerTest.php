<?php


namespace App\Tests\Unit\Pricing\Rate\Application\ProcessSeasonFile;


use PHPUnit\Framework\TestCase;
use Pricing\Rate\Application\ProcessSeasonFile\ProcessSeasonFileCommand;
use Pricing\Rate\Application\ProcessSeasonFile\ProcessSeasonFileCommandHandler;
use Pricing\Rate\Application\ProcessSeasonFile\ProcessSeasonFileResponse;
use Pricing\Rate\Infrastructure\SeasonFileDataExtractorExcel;
use Symfony\Component\Finder\SplFileInfo;

class ProcessSeasonFileCommandHandlerTest extends TestCase
{
    /**
     * @var ProcessSeasonFileCommandHandler
     */
    private $processSeasonFileCommandHandler;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|SeasonFileDataExtractorExcel
     */
    private $seasonFileDataExtractor;

    protected function setUp()
    {
        $this->seasonFileDataExtractor = $this->createMock(SeasonFileDataExtractorExcel::class);
        $this->processSeasonFileCommandHandler = new ProcessSeasonFileCommandHandler($this->seasonFileDataExtractor);
    }

    /**
     * @test
     */
    public function should_return_process_season_file_response_object()
    {
        $command = new ProcessSeasonFileCommand(new SplFileInfo('','',''));
        $response = $this->processSeasonFileCommandHandler->handle($command);
        $this->assertInstanceOf(ProcessSeasonFileResponse::class, $response);
    }

}