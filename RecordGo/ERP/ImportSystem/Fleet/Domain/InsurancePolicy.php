<?php

namespace ImportSystem\Fleet\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateTimeValueObject;

final class InsurancePolicy
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var Provider|null
     */
    private ?Provider $policyCompany;

    /**
     * @var string|null
     */
    private ?string $policyNumber;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $activationDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $finishDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $deactivationDate;


    /**
     * InsurancePolicy constructor.
     * 
     * @param int $id
     * @param Provider|null $policyCompany
     * @param string|null $policyNumber
     * @param DateTimeValueObject|null $activationDate
     * @param DateTimeValueObject|null $finishDate
     * @param DateTimeValueObject|null $deactivationDate
     */
    public function __construct(
        int $id,
        ?Provider $policyCompany,
        ?string $policyNumber,
        ?DateTimeValueObject $activationDate,
        ?DateTimeValueObject $finishDate,
        ?DateTimeValueObject $deactivationDate
    ) {
        $this->id = $id;
        $this->policyCompany = $policyCompany;
        $this->policyNumber = $policyNumber;
        $this->activationDate = $activationDate;
        $this->finishDate = $finishDate;
        $this->deactivationDate = $deactivationDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Provider|null
     */
    public function getPolicyCompany(): ?Provider
    {
        return $this->policyCompany;
    }

    /**
     * @return string|null
     */
    public function getPolicyNumber(): ?string
    {
        return $this->policyNumber;
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
     * @param array $insurancePolicyArray
     * @return self
     */
    public static function createFromArraySAP(array $insurancePolicyArray): self
    {
        return new self(
            intval($insurancePolicyArray['ID']),
            isset($insurancePolicyArray['PolicyCompany']) ? Provider::createFromArraySAP($insurancePolicyArray['PolicyCompany']) : null,
            $insurancePolicyArray['POLICYNUM'] ?? null,
            isset($insurancePolicyArray['ACTIVATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($insurancePolicyArray['ACTIVATIONDATE'])) : null,
            isset($insurancePolicyArray['FINISHDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($insurancePolicyArray['FINISHDATE'])) : null,
            isset($insurancePolicyArray['DEACTIVATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($insurancePolicyArray['DEACTIVATIONDATE'])) : null
        );
    }
}
