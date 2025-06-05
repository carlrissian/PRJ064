<?php


namespace Shared\Domain;


use Swift_OutputByteStream;

/**
 * Class FileToExportData
 * @package Shared\Domain
 */
class FileToExportData
{
    /**
     * @var string|Swift_OutputByteStream
     */
    private $data;
    /**
     * @var string
     */
    private $fileName;
    /**
     * @var string
     */
    private $contentType;

    /**
     * FileToExportData constructor.
     * @param string|Swift_OutputByteStream $data
     * @param string $fileName
     * @param string $contentType
     */
    public function __construct($data, string $fileName, string $contentType)
    {
        $this->data = $data;
        $this->fileName = $fileName;
        $this->contentType = $contentType;
    }

    /**
     * @return string|Swift_OutputByteStream
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }

    /**
     * @param string|Swift_OutputByteStream $data
     * @param string $fileName
     * @param string $contentType
     * @return FileToExportData
     */
    public static function create($data, string $fileName, string $contentType)
    {
        return new self($data, $fileName, $contentType);
    }
}