<?php


namespace Shared\Domain;


use Shared\Domain\ValueObject\DateTimeValueObject;

/**
 * Class Note
 * @package Mostrador\Shared\Domain
 */
abstract class Note
{
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var string
     */
    private $text;
    /**
     * @var int
     */
    private $userId;
    /**
     * @var DateTimeValueObject
     */
    private $date;

    /**
     * Note constructor.
     * @param int|null $id
     * @param string $text
     * @param int $userId
     * @param DateTimeValueObject $date
     */
    public function __construct(?int $id, string $text, int $userId, DateTimeValueObject $date)
    {
        $this->id = $id;
        $this->text = $text;
        $this->userId = $userId;
        $this->date = $date;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return DateTimeValueObject
     */
    public function getDate(): DateTimeValueObject
    {
        return $this->date;
    }





}