<?php

namespace ImportSystem\Fleet\Domain;

use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Utils\Utils;

final class Certificate
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTimeValueObject|null
     */
    private $activationDate;

    /**
     * @var DateTimeValueObject|null
     */
    private $finishDate;

    /**
     * @var DateTimeValueObject|null
     */
    private $deactivationDate;

    /**
     * @var InsurancePolicy|null
     */
    private $insurancePolicy;

    /**
     * Certificate constructor.
     *
     * @param integer $id
     * @param DateTimeValueObject|null $activationDate
     * @param DateTimeValueObject|null $finishDate
     * @param DateTimeValueObject|null $deactivationDate
     * @param InsurancePolicy|null $insurancePolicy
     */
    public function __construct(
        int $id,
        ?DateTimeValueObject $activationDate,
        ?DateTimeValueObject $finishDate,
        ?DateTimeValueObject $deactivationDate,
        ?InsurancePolicy $insurancePolicy = null
    ) {
        $this->id = $id;
        $this->activationDate = $activationDate;
        $this->finishDate = $finishDate;
        $this->deactivationDate = $deactivationDate;
        $this->insurancePolicy = $insurancePolicy;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getActivationDate(): ?DateTimeValueObject
    {
        return $this->activationDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getFinishDate(): ?DateTimeValueObject
    {
        return $this->finishDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getDeactivationDate(): ?DateTimeValueObject
    {
        return $this->deactivationDate;
    }

    /**
     * @return InsurancePolicy|null
     */
    public function getInsurancePolicy(): ?InsurancePolicy
    {
        return $this->insurancePolicy;
    }


    /**
     * @param array $certificateArray
     * @return self
     */
    public static function createFromArraySAP(array $certificateArray): self
    {
        return new self(
            intval($certificateArray['ID']),
            isset($certificateArray['ACTIVATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($certificateArray['ACTIVATIONDATE'])) : null,
            isset($certificateArray['FINISHDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($certificateArray['FINISHDATE'])) : null,
            isset($certificateArray['DEACTIVATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($certificateArray['DEACTIVATIONDATE'])) : null,
            isset($certificateArray['InsurancePolicy']) ? InsurancePolicy::createFromArraySAP($certificateArray['InsurancePolicy']) : null
        );
    }
}
