<?php


namespace Shared\Domain\Mailer;

interface MailerInterface
{
    /**
     * @param array $to
     * @param string $subject
     * @param array $images
     * @param array $atachment
     * @param string $body
     * @param string|null $from
     * @param string|null $fromName
     * @return int
     */
    public function send(array $to, string $subject, array $images, array $atachment, string $body, ?string $from, ?string $fromName): int;

}