<?php

namespace Shared\Domain\Mailer\Mailer;

use Shared\Domain\Mailer\Render\RendererInterface;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_OutputByteStream;

class SwiftMailer implements MailerInterface
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var Swift_Message
     */
    private $message;

    /**
     * SwiftMailer constructor.
     * @param Swift_Mailer $mailer
     * @param RendererInterface $renderer
     */
    public function __construct
    (
        Swift_Mailer $mailer,
        RendererInterface $renderer
    )
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
        $this->message = new Swift_Message();
    }

    /**
     * @param array $allEmbeddedImages
     * @param $data
     * @return array
     */
    private function addEmbeddedImages(array $allEmbeddedImages, $data):array
    {
        foreach($allEmbeddedImages AS $embeddedImage){
            $embeddedImagePath = __DIR__.$embeddedImage['path'];
            $data[ $embeddedImage['name'] ] = $this->message->embed(\Swift_Image::fromPath($embeddedImagePath));
        }
        return $data;
    }

    /**
     * @param string $from
     * @param array $recipients
     * @param string $template
     * @param array $data
     * @param array $embedImages
     */
    public function generateEmail(string $from, array $recipients, string $template, array $data, array $embedImages): void
    {
        $dataForTemplate = $this->addEmbeddedImages($embedImages, $data);
        $renderedEmail = $this->renderer->render($template, $dataForTemplate);
        $this->message
            ->setFrom($from)
            ->setTo($recipients)
            ->setSubject($renderedEmail->getSubject())
            ->setBody($renderedEmail->getBody())
            ->setContentType('text/html');
    }

    /**
     * @param string $filePath
     * @param string $attachmentName
     */
    public function attachFile(string $filePath, string $attachmentName): void
    {
        $this->message->attach(
            Swift_Attachment::fromPath(__DIR__.$filePath)->setFilename($attachmentName)
        );
    }

    /**
     * Method used when dataToExport does not need to be save.
     *
     * @param string|Swift_OutputByteStream $data
     * @param string                        $filename
     * @param string                        $contentType
     */
    public function attachExportedFile($data, $filename, $contentType): void
    {
        $this->message->attach(
            new Swift_Attachment($data, $filename, $contentType)
        );
    }

    /**
     *
     */
    public function send(): void
    {
        $this->mailer->send($this->message);
    }
}