<?php

namespace ImportSystem\Fleet\Application\ExportExcelFleet;

class ExportExcelFleetResponse
{
    /**
     * @var string
     */
    private string $tempFile;

    /**
     * @var string|null
     */
    private ?string $fileName;

    /**
     * @param string $tempFile
     * @param string|null $fileName
     */
    public function __construct(string $tempFile, ?string $fileName = null)
    {
        $this->tempFile = $tempFile;
        $this->fileName = $fileName;
    }

    /**
     * @return string
     */
    public function getTempFile(): string
    {
        return $this->tempFile;
    }

    /**
     * @return string|null
     */
    public function getFileName(): ?string
    {
        return $this->fileName;
    }
}
