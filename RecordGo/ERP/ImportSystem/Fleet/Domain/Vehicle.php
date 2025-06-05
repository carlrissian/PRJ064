<?php

namespace ImportSystem\Fleet\Domain;

use Shared\Utils\Utils;
use ImportSystem\Vehicle\Domain\VehicleStatus;
use Shared\Domain\ValueObject\DateTimeValueObject;
use ImportSystem\ColorMIR\Domain\ColorMIR;

final class Vehicle
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $vin;

    /**
     * @var string|null
     */
    private ?string $licensePlate;

    /**
     * @var string|null
     */
    private ?string $nive;

    /**
     * @var Acriss|null
     */
    private ?Acriss $acriss;

    /**
     * @var string|null
     */
    private ?string $color;

    /**
     * @var ColorMIR|null
     */
    private ?ColorMIR $colorMIR;

    /**
     * @var int|null
     */
    private ?int $colorMIRId;

    /**
     * @var float|null
     */
    private ?float $cv;

    /**
     * @var float|null
     */
    private ?float $bateryCapacity;

    /**
     * @var float|null
     */
    private ?float $tankCapacity;

    /**
     * @var int|null
     */
    private ?int $trunkCapacity;

    /**
     * @var int|null
     */
    private ?int $initialKms;

    /**
     * @var int|null
     */
    private ?int $actualKms;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $firstRegistrationDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $lastRegistrationDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $firstRentDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $rentingEndDate;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $firstAsssuranceDate;

    /**
     * @var VehicleStatus|null
     */
    private ?VehicleStatus $vehicleStatus;

    /**
     * @var Location|null
     */
    private ?Location $receptionLocation;

    /**
     * @var Location|null
     */
    private ?Location $actualLocation;

    /**
     * @var float|null
     */
    private ?float $invoiceAmountWithOutVat;

    /**
     * @var string|null
     */
    private ?string $invoiceNumber;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $invoiceDate;

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
     * @var SaleMethod|null
     */
    private ?SaleMethod $saleMethod;

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
     * @var VehicleType|null
     */
    private ?VehicleType $vehicleType;

    /**
     * @var VehicleGroup|null
     */
    private ?VehicleGroup $vehicleGroup;

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
     * @var float|null
     */
    private ?float $forfait;

    /**
     * @var string|null
     */
    private ?string $modelCode;

    /**
     * @var int|null
     */
    private ?int $height;

    /**
     * @var int|null
     */
    private ?int $interiorHeight;

    /**
     * @var int|null
     */
    private ?int $width;

    /**
     * @var int|null
     */
    private ?int $interiorWidth;

    /**
     * @var int|null
     */
    private ?int $length;

    /**
     * @var int|null
     */
    private ?int $interiorLength;

    /**
     * @var DateTimeValueObject|null
     */
    private ?DateTimeValueObject $creationDate;

    /**
     * Vehicle constructor.
     * 
     * @param int $id
     * @param string|null $vin
     * @param string|null $licensePlate
     * @param string|null $nive
     * @param Acriss|null $acriss
     * @param string|null $color
     * @param ColorMIR|null $colorMIR
     * @param int|null $colorMIRId
     * @param float|null $cv
     * @param float|null $bateryCapacity
     * @param float|null $tankCapacity
     * @param int|null $trunkCapacity
     * @param int|null $initialKms
     * @param int|null $actualKms
     * @param DateTimeValueObject|null $firstRegistrationDate
     * @param DateTimeValueObject|null $lastRegistrationDate
     * @param DateTimeValueObject|null $firstRentDate
     * @param DateTimeValueObject|null $rentingEndDate
     * @param DateTimeValueObject|null $firstAsssuranceDate
     * @param VehicleStatus|null $vehicleStatus
     * @param Location|null $receptionLocation
     * @param Location|null $actualLocation
     * @param float|null $invoiceAmountWithOutVat
     * @param string|null $invoiceNumber
     * @param DateTimeValueObject|null $invoiceDate
     * @param Provider|null $provider
     * @param Provider|null $bbCustomer
     * @param PurchaseType|null $purchaseType
     * @param SaleMethod|null $saleMethod
     * @param Brand|null $brand
     * @param Model|null $model
     * @param Trim|null $trim
     * @param string|null $vehicleSalesName
     * @param VehicleType|null $vehicleType
     * @param VehicleGroup|null $vehicleGroup
     * @param int|null $numOfDoors
     * @param VehicleSeats|null $vehicleSeats
     * @param int|null $carcc
     * @param float|null $co2
     * @param GearBox|null $gearBox
     * @param MotorType|null $motorType
     * @param float|null $motor
     * @param string|null $motorDenomination
     * @param float|null $kw
     * @param DateTimeValueObject|null $deliveryDate
     * @param DateTimeValueObject|null $returnDate
     * @param float|null $forfait
     * @param string|null $modelCode
     * @param int|null $height
     * @param int|null $interiorHeight
     * @param int|null $width
     * @param int|null $interiorWidth
     * @param int|null $length
     * @param int|null $interiorLength
     * @param DateTimeValueObject|null $creationDate
     */
    public function __construct(
        int $id,
        ?string $vin,
        ?string $licensePlate,
        ?string $nive,
        ?Acriss $acriss,
        ?string $color,
        ?ColorMIR $colorMIR,
        ?int $colorMIRId,
        ?float $cv,
        ?float $bateryCapacity,
        ?float $tankCapacity,
        ?int $trunkCapacity,
        ?int $initialKms,
        ?int $actualKms,
        ?DateTimeValueObject $firstRegistrationDate,
        ?DateTimeValueObject $lastRegistrationDate,
        ?DateTimeValueObject $firstRentDate,
        ?DateTimeValueObject $rentingEndDate,
        ?DateTimeValueObject $firstAsssuranceDate,
        ?VehicleStatus $vehicleStatus,
        ?Location $receptionLocation,
        ?Location $actualLocation,
        ?float $invoiceAmountWithOutVat,
        ?string $invoiceNumber,
        ?DateTimeValueObject $invoiceDate,
        ?Provider $provider,
        ?Provider $bbCustomer,
        ?PurchaseType $purchaseType,
        ?SaleMethod $saleMethod,
        ?Brand $brand,
        ?Model $model,
        ?Trim $trim,
        ?string $vehicleSalesName,
        ?VehicleType $vehicleType,
        ?VehicleGroup $vehicleGroup,
        ?int $numOfDoors,
        ?VehicleSeats $vehicleSeats,
        ?int $carcc,
        ?float $co2,
        ?GearBox $gearBox,
        ?MotorType $motorType,
        ?float $motor,
        ?string $motorDenomination,
        ?float $kw,
        ?DateTimeValueObject $deliveryDate,
        ?DateTimeValueObject $returnDate,
        ?float $forfait,
        ?string $modelCode,
        ?int $height,
        ?int $interiorHeight,
        ?int $width,
        ?int $interiorWidth,
        ?int $length,
        ?int $interiorLength,
        ?DateTimeValueObject $creationDate
    ) {
        $this->id = $id;
        $this->vin = $vin;
        $this->licensePlate = $licensePlate;
        $this->nive = $nive;
        $this->acriss = $acriss;
        $this->color = $color;
        $this->colorMIR = $colorMIR;
        $this->colorMIRId = $colorMIRId;
        $this->cv = $cv;
        $this->bateryCapacity = $bateryCapacity;
        $this->tankCapacity = $tankCapacity;
        $this->trunkCapacity = $trunkCapacity;
        $this->initialKms = $initialKms;
        $this->actualKms = $actualKms;
        $this->firstRegistrationDate = $firstRegistrationDate;
        $this->lastRegistrationDate = $lastRegistrationDate;
        $this->firstRentDate = $firstRentDate;
        $this->rentingEndDate = $rentingEndDate;
        $this->firstAsssuranceDate = $firstAsssuranceDate;
        $this->vehicleStatus = $vehicleStatus;
        $this->receptionLocation = $receptionLocation;
        $this->actualLocation = $actualLocation;
        $this->invoiceAmountWithOutVat = $invoiceAmountWithOutVat;
        $this->invoiceNumber = $invoiceNumber;
        $this->invoiceDate = $invoiceDate;
        $this->provider = $provider;
        $this->bbCustomer = $bbCustomer;
        $this->purchaseType = $purchaseType;
        $this->saleMethod = $saleMethod;
        $this->brand = $brand;
        $this->model = $model;
        $this->trim = $trim;
        $this->vehicleSalesName = $vehicleSalesName;
        $this->vehicleType = $vehicleType;
        $this->vehicleGroup = $vehicleGroup;
        $this->numOfDoors = $numOfDoors;
        $this->vehicleSeats = $vehicleSeats;
        $this->carcc = $carcc;
        $this->co2 = $co2;
        $this->gearBox = $gearBox;
        $this->motorType = $motorType;
        $this->motor = $motor;
        $this->motorDenomination = $motorDenomination;
        $this->kw = $kw;
        $this->deliveryDate = $deliveryDate;
        $this->returnDate = $returnDate;
        $this->forfait = $forfait;
        $this->modelCode = $modelCode;
        $this->height = $height;
        $this->interiorHeight = $interiorHeight;
        $this->width = $width;
        $this->interiorWidth = $interiorWidth;
        $this->length = $length;
        $this->interiorLength = $interiorLength;
        $this->creationDate = $creationDate;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getVin(): ?string
    {
        return $this->vin;
    }

    /**
     * @return string|null
     */
    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    /**
     * @return string|null
     */
    public function getNive(): ?string
    {
        return $this->nive;
    }

    /**
     * @return Acriss|null
     */
    public function getAcriss(): ?Acriss
    {
        return $this->acriss;
    }

    /**
     * @return string|null
     */
    public function getColor(): ?string
    {
        return $this->color;
    }

    /**
     * @return ColorMIR|null
     */
    public function getColorMIR(): ?ColorMIR
    {
        return $this->colorMIR;
    }

    /**
     * @return int|null
     */
    public function getColorMIRId(): ?int
    {
        return $this->colorMIRId;
    }

    /**
     * @return float|null
     */
    public function getCv(): ?float
    {
        return $this->cv;
    }

    /**
     * @return float|null
     */
    public function getBateryCapacity(): ?float
    {
        return $this->bateryCapacity;
    }

    /**
     * @return float|null
     */
    public function getTankCapacity(): ?float
    {
        return $this->tankCapacity;
    }

    /**
     * @return int|null
     */
    public function getTrunkCapacity(): ?int
    {
        return $this->trunkCapacity;
    }

    /**
     * @return int|null
     */
    public function getInitialKms(): ?int
    {
        return $this->initialKms;
    }

    /**
     * @return int|null
     */
    public function getActualKms(): ?int
    {
        return $this->actualKms;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getFirstRegistrationDate(): ?DateTimeValueObject
    {
        return $this->firstRegistrationDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getLastRegistrationDate(): ?DateTimeValueObject
    {
        return $this->lastRegistrationDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getFirstRentDate(): ?DateTimeValueObject
    {
        return $this->firstRentDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getRentingEndDate(): ?DateTimeValueObject
    {
        return $this->rentingEndDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getFirstAsssuranceDate(): ?DateTimeValueObject
    {
        return $this->firstAsssuranceDate;
    }

    /**
     * @return VehicleStatus|null
     */
    public function getVehicleStatus(): ?VehicleStatus
    {
        return $this->vehicleStatus;
    }

    /**
     * @return Location|null
     */
    public function getReceptionLocation(): ?Location
    {
        return $this->receptionLocation;
    }

    /**
     * @return Location|null
     */
    public function getActualLocation(): ?Location
    {
        return $this->actualLocation;
    }

    /**
     * @return float|null
     */
    public function getInvoiceAmountWithOutVat(): ?float
    {
        return $this->invoiceAmountWithOutVat;
    }

    /**
     * @return string|null
     */
    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getInvoiceDate(): ?DateTimeValueObject
    {
        return $this->invoiceDate;
    }

    /**
     * @return Provider|null
     */
    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    /**
     * @return Provider|null
     */
    public function getBbCustomer(): ?Provider
    {
        return $this->bbCustomer;
    }

    /**
     * @return PurchaseType|null
     */
    public function getPurchaseType(): ?PurchaseType
    {
        return $this->purchaseType;
    }

    /**
     * @return SaleMethod|null
     */
    public function getSaleMethod(): ?SaleMethod
    {
        return $this->saleMethod;
    }

    /**
     * @return Brand|null
     */
    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    /**
     * @return Model|null
     */
    public function getModel(): ?Model
    {
        return $this->model;
    }

    /**
     * @return Trim|null
     */
    public function getTrim(): ?Trim
    {
        return $this->trim;
    }

    /**
     * @return string|null
     */
    public function getVehicleSalesName(): ?string
    {
        return $this->vehicleSalesName;
    }

    /**
     * @return VehicleType|null
     */
    public function getVehicleType(): ?VehicleType
    {
        return $this->vehicleType;
    }

    /**
     * @return VehicleGroup|null
     */
    public function getVehicleGroup(): ?VehicleGroup
    {
        return $this->vehicleGroup;
    }

    /**
     * @return int|null
     */
    public function getNumOfDoors(): ?int
    {
        return $this->numOfDoors;
    }

    /**
     * @return VehicleSeats|null
     */
    public function getVehicleSeats(): ?VehicleSeats
    {
        return $this->vehicleSeats;
    }

    /**
     * @return int|null
     */
    public function getCarcc(): ?int
    {
        return $this->carcc;
    }

    /**
     * @return float|null
     */
    public function getCo2(): ?float
    {
        return $this->co2;
    }

    /**
     * @return GearBox|null
     */
    public function getGearBox(): ?GearBox
    {
        return $this->gearBox;
    }

    /**
     * @return MotorType|null
     */
    public function getMotorType(): ?MotorType
    {
        return $this->motorType;
    }

    /**
     * @return float|null
     */
    public function getMotor(): ?float
    {
        return $this->motor;
    }

    /**
     * @return string|null
     */
    public function getMotorDenomination(): ?string
    {
        return $this->motorDenomination;
    }

    /**
     * @return float|null
     */
    public function getKw(): ?float
    {
        return $this->kw;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getDeliveryDate(): ?DateTimeValueObject
    {
        return $this->deliveryDate;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getReturnDate(): ?DateTimeValueObject
    {
        return $this->returnDate;
    }

    /**
     * @return float|null
     */
    public function getForfait(): ?float
    {
        return $this->forfait;
    }

    /**
     * @return string|null
     */
    public function getModelCode(): ?string
    {
        return $this->modelCode;
    }

    /**
     * @return int|null
     */
    public function getHeight(): ?int
    {
        return $this->height;
    }

    /**
     * @return int|null
     */
    public function getInteriorHeight(): ?int
    {
        return $this->interiorHeight;
    }

    /**
     * @return int|null
     */
    public function getWidth(): ?int
    {
        return $this->width;
    }

    /**
     * @return int|null
     */
    public function getInteriorWidth(): ?int
    {
        return $this->interiorWidth;
    }

    /**
     * @return int|null
     */
    public function getLength(): ?int
    {
        return $this->length;
    }

    /**
     * @return int|null
     */
    public function getInteriorLength(): ?int
    {
        return $this->interiorLength;
    }

    /**
     * @return DateTimeValueObject|null
     */
    public function getCreationDate(): ?DateTimeValueObject
    {
        return $this->creationDate;
    }


    /**
     * @param array $vehicleArray
     * @return self
     */
    public static function createFromArraySAP(array $vehicleArray): self
    {
        return new self(
            intval($vehicleArray['ID']),
            $vehicleArray['VIN'] ?? null,
            $vehicleArray['LICENSEPLATE'] ?? null,
            $vehicleArray['NIVE'] ?? null,
            isset($vehicleArray['Acriss']) ? Acriss::createFromArraySAP($vehicleArray['Acriss']) : null,
            $vehicleArray['COLOR'] ?? null,
            isset($vehicleArray['ColorMIR']) ? ColorMIR::createFromArray($vehicleArray['ColorMIR']) : null,
            isset($vehicleArray['MIRCOLORSID']) ? intval($vehicleArray['MIRCOLORSID']) : null,
            isset($vehicleArray['HORSEPOWER']) ? floatval($vehicleArray['HORSEPOWER']) : null,
            isset($vehicleArray['BATERYCAPACITY']) ? floatval($vehicleArray['BATERYCAPACITY']) : null,
            isset($vehicleArray['TANKCAPACITY']) ? floatval($vehicleArray['TANKCAPACITY']) : null,
            isset($vehicleArray['TRUNKCAPACITY']) ? intval($vehicleArray['TRUNKCAPACITY']) : null,
            isset($vehicleArray['STARTKMS']) ? intval($vehicleArray['STARTKMS']) : null,
            isset($vehicleArray['ACTUALKMS']) ? intval($vehicleArray['ACTUALKMS']) : null,
            isset($vehicleArray['FIRSTREGISTRATIONDATE']) && !is_null($vehicleArray['FIRSTREGISTRATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['FIRSTREGISTRATIONDATE'])) : null,
            isset($vehicleArray['LASTREGISTRATIONDATE']) && !is_null($vehicleArray['LASTREGISTRATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['LASTREGISTRATIONDATE'])) : null,
            isset($vehicleArray['FIRSTRENTDATE']) && !is_null($vehicleArray['FIRSTRENTDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['FIRSTRENTDATE'])) : null,
            isset($vehicleArray['RENTINGENDDATE']) && !is_null($vehicleArray['RENTINGENDDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RENTINGENDDATE'])) : null,
            isset($vehicleArray['FIRSTASSSURANCEDATE']) && !is_null($vehicleArray['FIRSTASSSURANCEDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['FIRSTASSSURANCEDATE'])) : null,
            isset($vehicleArray['VehicleStatus']) ? VehicleStatus::createFromArraySAP($vehicleArray['VehicleStatus']) : null,
            isset($vehicleArray['ReceptionLocation']) ? Location::createFromArraySAP($vehicleArray['ReceptionLocation']) : null,
            isset($vehicleArray['ActualLocation']) ? Location::createFromArraySAP($vehicleArray['ActualLocation']) : null,
            isset($vehicleArray['INVOICEAMOUNTWITHOUTVAT']) ? floatval($vehicleArray['INVOICEAMOUNTWITHOUTVAT']) : null,
            $vehicleArray['INVOICENUMBER'] ?? null,
            isset($vehicleArray['INVOICEDATE']) && !is_null($vehicleArray['INVOICEDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['INVOICEDATE'])) : null,
            isset($vehicleArray['Provider']) ? Provider::createFromArraySAP($vehicleArray['Provider']) : null,
            isset($vehicleArray['BbCustomer']) ? Provider::createFromArraySAP($vehicleArray['BbCustomer']) : null,
            isset($vehicleArray['PurchaseType']) ? PurchaseType::createFromArraySAP($vehicleArray['PurchaseType']) : null,
            isset($vehicleArray['SaleMethod']) ? SaleMethod::createFromArraySAP($vehicleArray['SaleMethod']) : null,
            isset($vehicleArray['Trim']['Model']['Brand']) ? Brand::createFromArraySAP($vehicleArray['Trim']['Model']['Brand']) : null,
            isset($vehicleArray['Trim']['Model']) ? Model::createFromArraySAP($vehicleArray['Trim']['Model']) : null,
            isset($vehicleArray['Trim']) ? Trim::createFromArraySAP($vehicleArray['Trim']) : null,
            $vehicleArray['VEHICLESALESNAME'] ?? null,
            isset($vehicleArray['VehicleType']) ? VehicleType::createFromArraySAP($vehicleArray['VehicleType']) : null,
            isset($vehicleArray['VehicleGroup']) ? VehicleGroup::createFromArraySAP($vehicleArray['VehicleGroup']) : null,
            isset($vehicleArray['NUMOFDOORS']) ? intval($vehicleArray['NUMOFDOORS']) : null,
            isset($vehicleArray['VehicleSeats']) ? VehicleSeats::createFromArraySAP($vehicleArray['VehicleSeats']) : null,
            isset($vehicleArray['CARCC']) ? intval($vehicleArray['CARCC']) : null,
            isset($vehicleArray['CO2']) ? floatval($vehicleArray['CO2']) : null,
            isset($vehicleArray['GearBox']) ? GearBox::createFromArraySAP($vehicleArray['GearBox']) : null,
            isset($vehicleArray['MotorizationType']) ? MotorType::createFromArraySAP($vehicleArray['MotorizationType']) : null,
            isset($vehicleArray['MOTORCAPACITY']) ? floatval($vehicleArray['MOTORCAPACITY']) : null,
            $vehicleArray['MOTORDESIGNATION'] ?? null,
            isset($vehicleArray['MOTORKW']) ? floatval($vehicleArray['MOTORKW']) : null,
            isset($vehicleArray['INTDELIVERYDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['INTDELIVERYDATE'])) : null,
            isset($vehicleArray['RETURNDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['RETURNDATE'])) : null,
            isset($vehicleArray['FORFAIT']) ? floatval($vehicleArray['FORFAIT']) : null,
            $vehicleArray['MODELCODE'] ?? null,
            isset($vehicleArray['HEIGHT']) ? intval($vehicleArray['HEIGHT']) : null,
            isset($vehicleArray['INTERIORHEIGHT']) ? intval($vehicleArray['INTERIORHEIGHT']) : null,
            isset($vehicleArray['WIDTH']) ? intval($vehicleArray['WIDTH']) : null,
            isset($vehicleArray['INTERIORWIDTH']) ? intval($vehicleArray['INTERIORWIDTH']) : null,
            isset($vehicleArray['LENGTH']) ? intval($vehicleArray['LENGTH']) : null,
            isset($vehicleArray['INTERIORLENGTH']) ? intval($vehicleArray['INTERIORLENGTH']) : null,
            isset($vehicleArray['CREATIONDATE']) ? new DateTimeValueObject(Utils::convertOdataDateToDateTime($vehicleArray['CREATIONDATE'])) : null
        );
    }
}
