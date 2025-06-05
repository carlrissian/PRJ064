<?php

namespace ImportSystem\Fleet\Domain;

use Shared\Utils\Utils;
use Shared\Domain\ValueObject\DateTimeValueObject;
use ImportSystem\ColorMIR\Domain\ColorMIR;

final class AnexoLine
{
    /**
     * @var Provider|null
     */
    private ?Provider $provider;

    /**
     * @var Provider|null
     */
    private ?Provider $bbCustomer;

    /**
     * @var PurchaseType|null
     */
    private ?PurchaseType $purchaseType;

    /**
     * @var PurchaseMethod|null
     */
    private ?PurchaseMethod $purchaseMethod;

    /**
     * @var Brand|null
     */
    private ?Brand $brand;

    /**
     * @var Model|null
     */
    private ?Model $model;

    /**
     * @var Trim|null
     */
    private ?Trim $trim;

    /**
     * @var string|null
     */
    private ?string $vehicleSalesName;

    /**
     * @var VehicleGroup|null
     */
    private ?VehicleGroup $vehicleGroup;

    /**
     * @var VehicleType|null
     */
    private ?VehicleType $vehicleType;

    /**
     * @var int|null
     */
    private ?int $numOfDoors;

    /**
     * @var VehicleSeats|null
     */
    private ?VehicleSeats $vehicleSeats;

    /**
     * @var int|null
     */
    private ?int $carcc;

    /**
     * @var float|null
     */
    private ?float $co2;

    /**
     * @var GearBox|null
     */
    private ?GearBox $gearBox;

    /**
     * @var MotorType|null
     */
    private ?MotorType $motorType;

    /**
     * @var ColorMIR|null
     */
    private ?ColorMIR $colorMIR;

    /**
     * @var float|null
     */
    private ?float $motor;

    /**
     * @var string|null
     */
    private ?string $motorDenomination;

    /**
     * @var float|null
     */
    private ?float $kw;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $deliveryDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $returnDate;

    /**
     * @var int|null
     */
    private ?int $holdingPeriod;

    /**
     * @var float|null
     */
    private ?float $depreciationPerAmount;

    /**
     * @var int|null
     */
    private ?int $depreciationMonths;

    /**
     * @var float|null
     */
    private ?float $averageDamageAmount;

    /**
     * @var int|null
     */
    private ?int $averageMileage;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $averageRegistrationDate;

    /**
     * @var float|null
     */
    private ?float $forfait;

    /**
     * @var float|null
     */
    private ?float $excess;

    /**
     * @var float|null
     */
    private ?float $monthlyFee;

    /**
     * @var int|null
     */
    private ?int $minHoldingPeriodAmount;

    /**
     * @var string|null
     */
    private ?string $minHoldingPeriodKm;

    /**
     * @var float|null
     */
    private ?float $pffAmount;

    /**
     * @var float|null
     */
    private ?float $optionsAmount;

    /**
     * @var float|null
     */
    private ?float $purchaseDiscount;

    /**
     * @var float|null
     */
    private ?float $transportAmount;

    /**
     * @var float|null
     */
    private ?float $netAmount;

    /**
     * @var float|null
     */
    private ?float $taxUnitAmount;

    /**
     * @var Certificate|null
     */
    private ?Certificate $certificate;


    /**
     * @param Provider|null $provider
     * @param Provider|null $bbCustomer
     * @param PurchaseType|null $purchaseType
     * @param PurchaseMethod|null $purchaseMethod
     * @param Brand|null $brand
     * @param Model|null $model
     * @param Trim|null $trim
     * @param string|null $vehicleSalesName
     * @param VehicleGroup|null $vehicleGroup
     * @param VehicleType|null $vehicleType
     * @param int|null $numOfDoors
     * @param VehicleSeats|null $vehicleSeats
     * @param int|null $carcc
     * @param float|null $co2
     * @param GearBox|null $gearBox
     * @param MotorType|null $motorType
     * @param float|null $motor
     * @param string|null $motorDenomination
     * @param float|null $kw
     * @param ColorMIR|null $colorMIR
     * @param DateTimeValueObject|null $deliveryDate
     * @param DateTimeValueObject|null $returnDate
     * @param int|null $holdingPeriod
     * @param float|null $depreciationPerAmount
     * @param int|null $depreciationMonths
     * @param float|null $averageDamageAmount
     * @param int|null $averageMileage
     * @param DateTimeValueObject|null $averageRegistrationDate
     * @param float|null $forfait
     * @param float|null $excess
     * @param float|null $monthlyFee
     * @param int|null $minHoldingPeriodAmount
     * @param string|null $minHoldingPeriodKm
     * @param float|null $pffAmount
     * @param float|null $optionsAmount
     * @param float|null $purchaseDiscount
     * @param float|null $transportAmount
     * @param float|null $netAmount
     * @param float|null $taxUnitAmount
     * @param Certificate|null $certificate
     */
    public function __construct(
        ?Provider $provider,
        ?Provider $bbCustomer,
        ?PurchaseType $purchaseType,
        ?PurchaseMethod $purchaseMethod,
        ?Brand $brand,
        ?Model $model,
        ?Trim $trim,
        ?string $vehicleSalesName,
        ?VehicleGroup $vehicleGroup,
        ?VehicleType $vehicleType,
        ?int $numOfDoors,
        ?VehicleSeats $vehicleSeats,
        ?int $carcc,
        ?float $co2,
        ?GearBox $gearBox,
        ?MotorType $motorType,
        ?float $motor,
        ?string $motorDenomination,
        ?float $kw,
        ?ColorMIR $colorMIR,
        ?DateTimeValueObject $deliveryDate,
        ?DateTimeValueObject $returnDate,
        ?int $holdingPeriod,
        ?float $depreciationPerAmount,
        ?int $depreciationMonths,
        ?float $averageDamageAmount,
        ?int $averageMileage,
        ?DateTimeValueObject $averageRegistrationDate,
        ?float $forfait,
        ?float $excess,
        ?float $monthlyFee,
        ?int $minHoldingPeriodAmount,
        ?string $minHoldingPeriodKm,
        ?float $pffAmount,
        ?float $optionsAmount,
        ?float $purchaseDiscount,
        ?float $transportAmount,
        ?float $netAmount,
        ?float $taxUnitAmount,
        ?Certificate $certificate
    ) {
        $this->provider = $provider;
        $this->bbCustomer = $bbCustomer;
        $this->purchaseType = $purchaseType;
        $this->purchaseMethod = $purchaseMethod;
        $this->brand = $brand;
        $this->model = $model;
        $this->trim = $trim;
        $this->vehicleSalesName = $vehicleSalesName;
        $this->vehicleGroup = $vehicleGroup;
        $this->vehicleType = $vehicleType;
        $this->numOfDoors = $numOfDoors;
        $this->vehicleSeats = $vehicleSeats;
        $this->carcc = $carcc;
        $this->co2 = $co2;
        $this->gearBox = $gearBox;
        $this->motorType = $motorType;
        $this->motor = $motor;
        $this->motorDenomination = $motorDenomination;
        $this->kw = $kw;
        $this->colorMIR = $colorMIR;
        $this->deliveryDate = $deliveryDate;
        $this->returnDate = $returnDate;
        $this->holdingPeriod = $holdingPeriod;
        $this->depreciationPerAmount = $depreciationPerAmount;
        $this->depreciationMonths = $depreciationMonths;
        $this->averageDamageAmount = $averageDamageAmount;
        $this->averageMileage = $averageMileage;
        $this->averageRegistrationDate = $averageRegistrationDate;
        $this->forfait = $forfait;
        $this->excess = $excess;
        $this->monthlyFee = $monthlyFee;
        $this->minHoldingPeriodAmount = $minHoldingPeriodAmount;
        $this->minHoldingPeriodKm = $minHoldingPeriodKm;
        $this->pffAmount = $pffAmount;
        $this->optionsAmount = $optionsAmount;
        $this->purchaseDiscount = $purchaseDiscount;
        $this->transportAmount = $transportAmount;
        $this->netAmount = $netAmount;
        $this->taxUnitAmount = $taxUnitAmount;
        $this->certificate = $certificate;
    }

    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    public function getBbCustomer(): ?Provider
    {
        return $this->bbCustomer;
    }

    public function getPurchaseType(): ?PurchaseType
    {
        return $this->purchaseType;
    }

    public function getPurchaseMethod(): ?PurchaseMethod
    {
        return $this->purchaseMethod;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function getTrim(): ?Trim
    {
        return $this->trim;
    }

    public function getVehicleSalesName(): ?string
    {
        return $this->vehicleSalesName;
    }

    public function getVehicleGroup(): ?VehicleGroup
    {
        return $this->vehicleGroup;
    }

    public function getVehicleType(): ?VehicleType
    {
        return $this->vehicleType;
    }

    public function getNumOfDoors(): ?int
    {
        return $this->numOfDoors;
    }

    public function getVehicleSeats(): ?VehicleSeats
    {
        return $this->vehicleSeats;
    }

    public function getCarcc(): ?int
    {
        return $this->carcc;
    }

    public function getCo2(): ?float
    {
        return $this->co2;
    }

    public function getGearBox(): ?GearBox
    {
        return $this->gearBox;
    }

    public function getMotorType(): ?MotorType
    {
        return $this->motorType;
    }

    public function getMotor(): ?float
    {
        return $this->motor;
    }

    public function getMotorDenomination(): ?string
    {
        return $this->motorDenomination;
    }

    public function getKw(): ?float
    {
        return $this->kw;
    }

    public function getColorMIR(): ?ColorMIR
    {
        return $this->colorMIR;
    }

    public function getDeliveryDate(): ?DateTimeValueObject
    {
        return $this->deliveryDate;
    }

    public function getReturnDate(): ?DateTimeValueObject
    {
        return $this->returnDate;
    }

    public function getHoldingPeriod(): ?int
    {
        return $this->holdingPeriod;
    }

    public function getDepreciationPerAmount(): ?float
    {
        return $this->depreciationPerAmount;
    }

    public function getDepreciationMonths(): ?int
    {
        return $this->depreciationMonths;
    }

    public function getAverageDamageAmount(): ?float
    {
        return $this->averageDamageAmount;
    }

    public function getAverageMileage(): ?int
    {
        return $this->averageMileage;
    }

    public function getAverageRegistrationDate(): ?DateTimeValueObject
    {
        return $this->averageRegistrationDate;
    }

    public function getForfait(): ?float
    {
        return $this->forfait;
    }

    public function getExcess(): ?float
    {
        return $this->excess;
    }

    public function getMonthlyFee(): ?float
    {
        return $this->monthlyFee;
    }

    public function getMinHoldingPeriodAmount(): ?int
    {
        return $this->minHoldingPeriodAmount;
    }

    public function getMinHoldingPeriodKm(): ?string
    {
        return $this->minHoldingPeriodKm;
    }

    public function getPffAmount(): ?float
    {
        return $this->pffAmount;
    }

    public function getOptionsAmount(): ?float
    {
        return $this->optionsAmount;
    }

    public function getPurchaseDiscount(): ?float
    {
        return $this->purchaseDiscount;
    }

    public function getTransportAmount(): ?float
    {
        return $this->transportAmount;
    }

    public function getNetAmount(): ?float
    {
        return $this->netAmount;
    }

    public function getTaxUnitAmount(): ?float
    {
        return $this->taxUnitAmount;
    }

    /**
     * @return Certificate|null
     */
    public function getCertificate(): ?Certificate
    {
        return $this->certificate;
    }


    /**
     * @param array|null $anexoLineArray
     * @return self
     */
    public static function createFromArraySAP(?array $anexoLineArray): self
    {
        return new self(
            isset($anexoLineArray['Provider']) ? Provider::createFromArraySAP($anexoLineArray['Provider']) : null,
            isset($anexoLineArray['BbCustomer']) ? Provider::createFromArraySAP($anexoLineArray['BbCustomer']) : null,
            isset($anexoLineArray['PurchaseType']) ? PurchaseType::createFromArraySAP($anexoLineArray['PurchaseType']) : null,
            isset($anexoLineArray['PurchaseMethod']) ? PurchaseMethod::createFromArraySAP($anexoLineArray['PurchaseMethod']) : null,
            isset($anexoLineArray['Brand']) ? Brand::createFromArraySAP($anexoLineArray['Brand']) : null,
            isset($anexoLineArray['Model']) ? Model::createFromArraySAP($anexoLineArray['Model']) : null,
            isset($anexoLineArray['Trim']) ? Trim::createFromArraySAP($anexoLineArray['Trim']) : null,
            $anexoLineArray['VEHICLESALESNAME'] ?? null,
            isset($anexoLineArray['VehicleGroup']) ? VehicleGroup::createFromArraySAP($anexoLineArray['VehicleGroup']) : null,
            isset($anexoLineArray['VehicleType']) ? VehicleType::createFromArraySAP($anexoLineArray['VehicleType']) : null,
            isset($anexoLineArray['NUMOFDOORS']) ? intval($anexoLineArray['NUMOFDOORS']) : null,
            isset($anexoLineArray['VehicleSeats']) ? VehicleSeats::createFromArraySAP($anexoLineArray['VehicleSeats']) : null,
            isset($anexoLineArray['CARCC']) ? intval($anexoLineArray['CARCC']) : null,
            isset($anexoLineArray['CO2']) ? floatval($anexoLineArray['CO2']) : null,
            isset($anexoLineArray['GearBox']) ? GearBox::createFromArraySAP($anexoLineArray['GearBox']) : null,
            isset($anexoLineArray['MotorType']) ? MotorType::createFromArraySAP($anexoLineArray['MotorType']) : null,
            isset($anexoLineArray['MOTORCAPACITY']) ? floatval($anexoLineArray['MOTORCAPACITY']) : null,
            $anexoLineArray['MOTORDESIGNATION'] ?? null,
            isset($anexoLineArray['MOTORKW']) ? floatval($anexoLineArray['MOTORKW']) : null,
            isset($anexoLineArray['ColorMIR']) ? ColorMIR::createFromArray($anexoLineArray['ColorMIR']) : null,
            isset($anexoLineArray['DELIVERYDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($anexoLineArray['DELIVERYDATE'])) : null,
            isset($anexoLineArray['RETURNDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($anexoLineArray['RETURNDATE'])) : null,
            isset($anexoLineArray['HOLDINGPERIOD']) ? intval($anexoLineArray['HOLDINGPERIOD']) : null,
            isset($anexoLineArray['DEPRECIATIONPERAMOUNT']) ? floatval($anexoLineArray['DEPRECIATIONPERAMOUNT']) : null,
            isset($anexoLineArray['DEPRECIATIONMONTHS']) ? intval($anexoLineArray['DEPRECIATIONMONTHS']) : null,
            isset($anexoLineArray['AVERAGEDAMAGEAMOUNT']) ? floatval($anexoLineArray['AVERAGEDAMAGEAMOUNT']) : null,
            isset($anexoLineArray['AVERAGEMILEAGE']) ? intval($anexoLineArray['AVERAGEMILEAGE']) : null,
            isset($anexoLineArray['AVERAGEREGISTRATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($anexoLineArray['AVERAGEREGISTRATIONDATE'])) : null,
            isset($anexoLineArray['FORFAIT']) ? floatval($anexoLineArray['FORFAIT']) : null,
            isset($anexoLineArray['EXCESS']) ? floatval($anexoLineArray['EXCESS']) : null,
            isset($anexoLineArray['MONTHLYFEE']) ? floatval($anexoLineArray['MONTHLYFEE']) : null,
            isset($anexoLineArray['MINHOLDINGPERIODAMOUNT']) ? intval($anexoLineArray['MINHOLDINGPERIODAMOUNT']) : null,
            $anexoLineArray['MINHOLDINGPERIODKM'] ?? null,
            isset($anexoLineArray['PFFAMOUNT']) ? floatval($anexoLineArray['PFFAMOUNT']) : null,
            isset($anexoLineArray['OPTIONSAMOUNT']) ? floatval($anexoLineArray['OPTIONSAMOUNT']) : null,
            isset($anexoLineArray['PURCHASEDISCOUNT']) ? floatval($anexoLineArray['PURCHASEDISCOUNT']) : null,
            isset($anexoLineArray['TRANSPORTAMOUNT']) ? floatval($anexoLineArray['TRANSPORTAMOUNT']) : null,
            isset($anexoLineArray['NETAMOUNT']) ? floatval($anexoLineArray['NETAMOUNT']) : null,
            isset($anexoLineArray['TAXUNITAMOUNT']) ? floatval($anexoLineArray['TAXUNITAMOUNT']) : null,
            isset($anexoLineArray['Certificate']) ? Certificate::createFromArraySAP($anexoLineArray['Certificate']) : null
        );
    }
}
