<?php

namespace ImportSystem\CarGroup\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateTimeValueObject;

/**
 * Class CarGroup
 * @package Distribution\CarGroup\Domain
 */
class CarGroup
{
    /**
     * @var int|null
     */
    private ?int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var bool|null
     */
    private ?bool $enabled;

    /**
     * @var int|null
     */
    private ?int $creationUserId;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * @var int|null
     */
    private ?int $updateUser;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $updateDate;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param bool|null $enabled
     * @param int|null $creationUserId
     * @param DateTimeValueObject|null $creationDate
     * @param int|null $updateUser
     * @param DateTimeValueObject|null $updateDate
     */
    public function __construct(
        ?int $id,
        ?string $name = null,
        ?bool $enabled = null,
        ?int $creationUserId = null,
        ?DateTimeValueObject $creationDate = null,
        ?int $updateUser = null,
        ?DateTimeValueObject $updateDate = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->enabled = $enabled;
        $this->creationUserId = $creationUserId;
        $this->creationDate = $creationDate;
        $this->updateUser = $updateUser;
        $this->updateDate = $updateDate;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int|null
     */
    public function getCreationUserId(): ?int
    {
        return $this->creationUserId;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }

    /**
     * @return int|null
     */
    public function getUpdateUser(): ?int
    {
        return $this->updateUser;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getUpdateDate(): ?DateTimeValueObject
    {
        return $this->updateDate;
    }


    /**
     * @return array|mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }


    /**
     * @param array|null $carGroupArray
     * @return self
     */
    public static function createFromArray(?array $carGroupArray): self
    {
        return new self(
            intval($carGroupArray['ID']),
            $carGroupArray['VEHICLEGROUPNAME'] ?? null,
            filter_var($carGroupArray['VEHICLEGROUPSTATUS'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            isset($carGroupArray['CREATIONUSERID']) ? intval($carGroupArray['CREATIONUSERID']) : null,
            isset($vehicleArray['CREATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['CREATIONDATE'])) : null,
            isset($carGroupArray['EDITIONUSERID']) ? intval($carGroupArray['EDITIONUSERID']) : null,
            isset($vehicleArray['EDITIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['EDITIONDATE'])) : null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            'VEHICLEGROUPNAME' => $this->getName(),
            'VEHICLEGROUPSTATUS' => $this->isEnabled() ? 1 : 0,
        ];
    }
}
