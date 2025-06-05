<?php


namespace Shared\Domain\Mailer\Render;


class RenderedEmail
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    public function __construct(string $subject, string $body)
    {
        $this->subject = $subject;
        $this->body = $body;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}