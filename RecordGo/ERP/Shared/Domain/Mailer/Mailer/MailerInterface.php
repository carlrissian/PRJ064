<?php


namespace Shared\Domain\Mailer\Mailer;


use Swift_OutputByteStream;

interface MailerInterface
{
    /**
     * @param string $from
     * @param array $recipients
     * @param string $template
     * @param array $data
     * @param array $embedImages
     */
    public function generateEmail(string $from, array $recipients, string $template, array $data, array $embedImages): void;

    /**
     * @param string $filePath
     * @param string $attachmentName
     */
    public function attachFile(string $filePath, string $attachmentName): void;

    /**
     * Method used when dataToExport does not need to be save.
     *
     * @param string|Swift_OutputByteStream $data
     * @param string                        $filename
     * @param string                        $contentType
     */
    public function attachExportedFile($data, $filename, $contentType): void;

    /**
     *
     */
    public function send(): void;
}