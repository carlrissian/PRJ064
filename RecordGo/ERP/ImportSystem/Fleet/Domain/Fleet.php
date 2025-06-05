<?php

namespace ImportSystem\Fleet\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateTimeValueObject;

class Fleet
{
    private ?Anexo1Head $anexo1Head;
    private ?AnexoLine $anexoLine;
    private ?Vehicle $vehicle;
    //TODO Falta saber que tipo de campos son, desde WS no tengo ejemplos.
    private ?DateTimeValueObject $accountingDate;
    private ?string $capAmount;
    private ?DateTimeValueObject $fixedAssetRegistrationDate;
    private ?string $fixedAssetClass;
    private ?DateTimeValueObject $amortizationStartDate;
    private ?string $amortizationClass;
    private ?string $financingType;
    private ?string $fromThirdParties;
    private ?string $leasePercentage;
    private ?string $repurchaseMonths;
    private ?string $businessUnit;
    private ?string $area;
    private ?string $provisionGenerates;

    /**
     * @param Anexo1Head|null $anexo1Head
     * @param AnexoLine|null $anexoLine
     * @param Vehicle|null $vehicle
     * @param DateTimeValueObject|null $accountingDate
     * @param string|null $capAmount
     * @param DateTimeValueObject|null $fixedAssetRegistrationDate
     * @param string|null $fixedAssetClass
     * @param DateTimeValueObject|null $amortizationStartDate
     * @param string|null $amortizationClass
     * @param string|null $financingType
     * @param string|null $fromThirdParties
     * @param string|null $leasePercentage
     * @param string|null $repurchaseMonths
     * @param string|null $businessUnit
     * @param string|null $area
     * @param string|null $provisionGenerates
     */
    public function __construct(
        ?Anexo1Head $anexo1Head,
        ?AnexoLine $anexoLine,
        ?Vehicle $vehicle,
        ?DateTimeValueObject $accountingDate,
        ?string $capAmount,
        ?DateTimeValueObject $fixedAssetRegistrationDate,
        ?string $fixedAssetClass,
        ?DateTimeValueObject $amortizationStartDate,
        ?string $amortizationClass,
        ?string $financingType,
        ?string $fromThirdParties,
        ?string $leasePercentage,
        ?string $repurchaseMonths,
        ?string $businessUnit,
        ?string $area,
        ?string $provisionGenerates
    ) {
        $this->anexo1Head = $anexo1Head;
        $this->anexoLine = $anexoLine;
        $this->vehicle = $vehicle;
        $this->accountingDate = $accountingDate;
        $this->capAmount = $capAmount;
        $this->fixedAssetRegistrationDate = $fixedAssetRegistrationDate;
        $this->fixedAssetClass = $fixedAssetClass;
        $this->amortizationStartDate = $amortizationStartDate;
        $this->amortizationClass = $amortizationClass;
        $this->financingType = $financingType;
        $this->fromThirdParties = $fromThirdParties;
        $this->leasePercentage = $leasePercentage;
        $this->repurchaseMonths = $repurchaseMonths;
        $this->businessUnit = $businessUnit;
        $this->area = $area;
        $this->provisionGenerates = $provisionGenerates;
    }

    public function getAnexo1Head(): ?Anexo1Head
    {
        return $this->anexo1Head;
    }

    public function getAnexoLine(): ?AnexoLine
    {
        return $this->anexoLine;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function getAccountingDate(): ?DateTimeValueObject
    {
        return $this->accountingDate;
    }

    public function getCapAmount(): ?string
    {
        return $this->capAmount;
    }

    public function getFixedAssetRegistrationDate(): ?DateTimeValueObject
    {
        return $this->fixedAssetRegistrationDate;
    }

    public function getFixedAssetClass(): ?string
    {
        return $this->fixedAssetClass;
    }

    public function getAmortizationStartDate(): ?DateTimeValueObject
    {
        return $this->amortizationStartDate;
    }

    public function getAmortizationClass(): ?string
    {
        return $this->amortizationClass;
    }

    public function getFinancingType(): ?string
    {
        return $this->financingType;
    }

    public function getFromThirdParties(): ?string
    {
        return $this->fromThirdParties;
    }

    public function getLeasePercentage(): ?string
    {
        return $this->leasePercentage;
    }

    public function getRepurchaseMonths(): ?string
    {
        return $this->repurchaseMonths;
    }

    public function getBusinessUnit(): ?string
    {
        return $this->businessUnit;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function getProvisionGenerates(): ?string
    {
        return $this->provisionGenerates;
    }


    /**
     * @param array $fleetArray
     * @return self
     */
    public static function createFromArraySAP(array $fleetArray): self
    {
        return new self(
            isset($fleetArray['Anexo1Head']) ? Anexo1Head::createFromArraySAP($fleetArray['Anexo1Head']) : null,
            isset($fleetArray['AnexoLine']) ? AnexoLine::createFromArraySAP($fleetArray['AnexoLine']) : null,
            isset($fleetArray['Vehicle']) ? Vehicle::createFromArraySAP($fleetArray['Vehicle']) : null,
            isset($fleetArray['ACCOUNTINGDATE']) ?  new DateTimeValueObject(Utils::convertOdataDateToDateTime($fleetArray['ACCOUNTINGDATE'])) : null,
            $fleetArray['CAPAMOUNT'] ?? null,
            isset($fleetArray['FIXEDASSETREGISTRATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($fleetArray['FIXEDASSETREGISTRATIONDATE'])) : null,
            $fleetArray['FIXEDASSETCLASS'] ?? null,
            isset($fleetArray['AMORTIZATIONSTARTDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($fleetArray['AMORTIZATIONSTARTDATE'])) : null,
            $fleetArray['AMORTIZATIONCLASS'] ?? null,
            $fleetArray['FINANCINGTYPE'] ?? null,
            $fleetArray['FROMTHIRDPARTIES'] ?? null,
            $fleetArray['LEASEPERCENTAGE'] ?? null,
            $fleetArray['REPURCHASEMONTHS'] ?? null,
            $fleetArray['BUSINESSUNIT'] ?? null,
            $fleetArray['AREA'] ?? null,
            $fleetArray['PROVISIONGENERATES'] ?? null
        );
    }
}
