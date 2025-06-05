<?php


namespace Shared\Domain\Mailer;


use Shared\Domain\ValueObject\DateTimeValueObject;

/**
 * Class MailSentData
 * @package Shared\Domain\Mailer
 */
class MailSentData
{
    const MAIL_SENT = 'MAIL_SENDED';
    const MAIL_NOT_SENT = 'MAIL_NOT_SENDED';
    /**
     * @var DateTimeValueObject
     */
    private $sendDate;
    /**
     * @var string
     */
    private $userName;
    /**
     * @var SentData
     */
    private $sentData;
    /**
     * @var string
     */
    private $sendStatus;

    /**
     * MailSentData constructor.
     * @param DateTimeValueObject $sendDate
     * @param string $userName
     * @param SentData $sentData
     * @param string $sendStatus
     */
    public function __construct(DateTimeValueObject $sendDate, string $userName, SentData $sentData, string $sendStatus)
    {
        $this->sendDate = $sendDate;
        $this->userName = $userName;
        $this->sentData = $sentData;
        $this->sendStatus = $sendStatus;
    }

    /**
     * @return DateTimeValueObject
     */
    public function getSendDate(): DateTimeValueObject
    {
        return $this->sendDate;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return SentData
     */
    public function getSentData(): SentData
    {
        return $this->sentData;
    }

    /**
     * @return string
     */
    public function getSendStatus(): string
    {
        return $this->sendStatus;
    }

    /**
     * @param DateTimeValueObject $sendDate
     * @param string $userName
     * @param SentData $sentData
     * @param string $sendStatus
     * @return MailSentData
     */
    public static function create(DateTimeValueObject $sendDate, string $userName, SentData $sentData, string $sendStatus)
    {
        return new self ($sendDate, $userName, $sentData, $sendStatus);
    }

}