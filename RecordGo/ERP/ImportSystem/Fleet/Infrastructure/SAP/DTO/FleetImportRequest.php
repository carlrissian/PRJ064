<?php

namespace ImportSystem\Fleet\Infrastructure\SAP\DTO;

use Shared\Utils\Utils;
use Shared\Constants\Infrastructure\ConstantsJsonFile;

final class FleetImportRequest
{
    private ?string $anexo1IntRef;
    private string $supplierName;
    private ?string $bbCustomerName;
    private string $purchaseTypeName;
    private string $purchaseMethodName;
    private string $brandName;
    private string $modelName;
    private string $trimName;
    private string $vehicleSalesName;
    private string $vehicleGroupName;
    private ?string $vehicleTypeName;
    private int $numOfDoors;
    private string $vehicleSeatValue;
    private ?float $co2;
    private int $carcc;
    private string $gearBoxType;
    private string $motorTypeName;
    private string $deliverydate;
    private string $returndate;

    private ?float $depreciationPerAmount;
    private ?int $depreciationmonths;
    private string $insurancePolicyNumber;
    private string $insurancePolicyCompanyId;
    private ?string $insuranceActivationDate;
    private ?string $insuranceFinishDate;
    private ?float $averageDamageAmount;
    private ?int $averageMileage;
    private ?string $averageRegistrationDate;
    private string $receptionLocationName;
    private ?float $forfait;
    private ?int $height;
    private ?int $interiorHeight;
    private ?int $width;
    private ?int $interiorWidth;
    private ?int $length;
    private ?int $interiorLength;
    private ?float $excess;
    private ?float $monthlyFee;
    private ?int $minHoldingPeriodAmount;
    private ?string $minHoldingPeriodKm;
    private ?float $pffAmount;
    private ?float $optionsamount;
    private ?float $purchasediscount;
    private ?float $transportamount;
    private float $netamount;
    private string $vin;
    private ?string $licensePlate;
    private ?string $nive;
    private string $acrissCode;
    private string $color;
    private string $cv;
    private ?string $baterycapacity;
    private ?string $tankcapacity;
    private ?string $trunkcapacity;
    private ?string $actualkms;
    private ?string $firstRegistrationDate;
    private ?string $lastRegistrationDate;
    private string $firstRentDate;
    private string $rentingEndDate;
    private ?string $firstAsssuranceDate;
    private string $vehicleStatusName;
    private ?string $actualLocationName;
    private ?float $invoiceAmountWithOutVat;
    private ?string $invoiceNumber;
    private ?string $invoiceDate;
    private ?string $accountingDate;
    private ?string $capAmount;
    private ?string $fixedAssetRegistrationDate;
    private ?string $fixedAssetClass;
    private ?string $amortizationStartDate;
    private ?string $amortizationClass;
    private ?string $financingType;
    private ?string $fromThirdParties;
    private ?string $leasePercentage;
    private ?string $repurchaseMonths;
    private ?string $businessUnit;
    private ?string $area;
    private ?string $provisionGenerates;

    /**
     * @param string|null $anexo1IntRef
     * @param string $supplierName
     * @param string|null $bbCustomerName
     * @param string $purchaseTypeName
     * @param string $purchaseMethodName
     * @param string $brandName
     * @param string $modelName
     * @param string $trimName
     * @param string $vehicleSalesName
     * @param string $vehicleGroupName
     * @param string|null $vehicleTypeName
     * @param int $numOfDoors
     * @param string $vehicleSeatValue
     * @param float|null $co2
     * @param int $carcc
     * @param string $gearBoxType
     * @param string $motorTypeName
     * @param string $deliverydate
     * @param string $returndate
     * @param float|null $depreciationPerAmount
     * @param int|null $depreciationmonths
     * @param string $insurancePolicyNumber
     * @param string $insurancePolicyCompanyId
     * @param string|null $insuranceActivationDate
     * @param string|null $insuranceFinishDate
     * @param float|null $averageDamageAmount
     * @param int|null $averageMileage
     * @param string|null $averageRegistrationDate
     * @param string $receptionLocationName
     * @param float|null $forfait
     * @param int|null $height
     * @param int|null $interiorHeight
     * @param int|null $width
     * @param int|null $interiorWidth
     * @param int|null $length
     * @param int|null $interiorLength
     * @param float|null $excess
     * @param float|null $monthlyFee
     * @param int|null $minHoldingPeriodAmount
     * @param string|null $minHoldingPeriodKm
     * @param float|null $pffAmount
     * @param float|null $optionsamount
     * @param float|null $purchasediscount
     * @param float|null $transportamount
     * @param float $netamount
     * @param string $vin
     * @param string|null $licensePlate
     * @param string|null $nive
     * @param string $acrissCode
     * @param string $color
     * @param string $cv
     * @param string|null $baterycapacity
     * @param string|null $tankcapacity
     * @param string|null $trunkcapacity
     * @param string|null $actualkms
     * @param string|null $firstRegistrationDate
     * @param string|null $lastRegistrationDate
     * @param string $firstRentDate
     * @param string $rentingEndDate
     * @param string|null $firstAsssuranceDate
     * @param string $vehicleStatusName
     * @param string|null $actualLocationName
     * @param float|null $invoiceAmountWithOutVat
     * @param string|null $invoiceNumber
     * @param string|null $invoiceDate
     * @param string|null $accountingDate
     * @param string|null $capAmount
     * @param string|null $fixedAssetRegistrationDate
     * @param string|null $fixedAssetClass
     * @param string|null $amortizationStartDate
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
        ?string $anexo1IntRef,
        string $supplierName,
        ?string $bbCustomerName,
        string $purchaseTypeName,
        string $purchaseMethodName,
        string $brandName,
        string $modelName,
        string $trimName,
        string $vehicleSalesName,
        string $vehicleGroupName,
        ?string $vehicleTypeName,
        int $numOfDoors,
        string $vehicleSeatValue,
        ?float $co2,
        int $carcc,
        string $gearBoxType,
        string $motorTypeName,
        string $deliverydate,
        string $returndate,
        ?float $depreciationPerAmount,
        ?int $depreciationmonths,
        string $insurancePolicyNumber,
        string $insurancePolicyCompanyId,
        ?string $insuranceActivationDate,
        ?string $insuranceFinishDate,
        ?float $averageDamageAmount,
        ?int $averageMileage,
        ?string $averageRegistrationDate,
        string $receptionLocationName,
        ?float $forfait,
        ?int $height,
        ?int $interiorHeight,
        ?int $width,
        ?int $interiorWidth,
        ?int $length,
        ?int $interiorLength,
        ?float $excess,
        ?float $monthlyFee,
        ?int $minHoldingPeriodAmount,
        ?string $minHoldingPeriodKm,
        ?float $pffAmount,
        ?float $optionsamount,
        ?float $purchasediscount,
        ?float $transportamount,
        float $netamount,
        string $vin,
        ?string $licensePlate,
        ?string $nive,
        string $acrissCode,
        string $color,
        string $cv,
        ?string $baterycapacity,
        ?string $tankcapacity,
        ?string $trunkcapacity,
        ?string $actualkms,
        ?string $firstRegistrationDate,
        ?string $lastRegistrationDate,
        string $firstRentDate,
        string $rentingEndDate,
        ?string $firstAsssuranceDate,
        string $vehicleStatusName,
        ?string $actualLocationName,
        ?float $invoiceAmountWithOutVat,
        ?string $invoiceNumber,
        ?string $invoiceDate,
        ?string $accountingDate,
        ?string $capAmount,
        ?string $fixedAssetRegistrationDate,
        ?string $fixedAssetClass,
        ?string $amortizationStartDate,
        ?string $amortizationClass,
        ?string $financingType,
        ?string $fromThirdParties,
        ?string $leasePercentage,
        ?string $repurchaseMonths,
        ?string $businessUnit,
        ?string $area,
        ?string $provisionGenerates
    ) {
        $this->anexo1IntRef = $anexo1IntRef;
        $this->supplierName = $supplierName;
        $this->bbCustomerName = $bbCustomerName;
        $this->purchaseTypeName = $purchaseTypeName;
        $this->purchaseMethodName = $purchaseMethodName;
        $this->brandName = $brandName;
        $this->modelName = $modelName;
        $this->trimName = $trimName;
        $this->vehicleSalesName = $vehicleSalesName;
        $this->vehicleGroupName = $vehicleGroupName;
        $this->vehicleTypeName = $vehicleTypeName;
        $this->numOfDoors = $numOfDoors;
        $this->vehicleSeatValue = $vehicleSeatValue;
        $this->co2 = $co2;
        $this->carcc = $carcc;
        $this->gearBoxType = $gearBoxType;
        $this->motorTypeName = $motorTypeName;
        $this->deliverydate = $deliverydate;
        $this->returndate = $returndate;
        $this->depreciationPerAmount = $depreciationPerAmount;
        $this->depreciationmonths = $depreciationmonths;
        $this->insurancePolicyNumber = $insurancePolicyNumber;
        $this->insurancePolicyCompanyId = $insurancePolicyCompanyId;
        $this->insuranceActivationDate = $insuranceActivationDate;
        $this->insuranceFinishDate = $insuranceFinishDate;
        $this->averageDamageAmount = $averageDamageAmount;
        $this->averageMileage = $averageMileage;
        $this->averageRegistrationDate = $averageRegistrationDate;
        $this->receptionLocationName = $receptionLocationName;
        $this->forfait = $forfait;
        $this->height = $height;
        $this->interiorHeight = $interiorHeight;
        $this->width = $width;
        $this->interiorWidth = $interiorWidth;
        $this->length = $length;
        $this->interiorLength = $interiorLength;
        $this->excess = $excess;
        $this->monthlyFee = $monthlyFee;
        $this->minHoldingPeriodAmount = $minHoldingPeriodAmount;
        $this->minHoldingPeriodKm = $minHoldingPeriodKm;
        $this->pffAmount = $pffAmount;
        $this->optionsamount = $optionsamount;
        $this->purchasediscount = $purchasediscount;
        $this->transportamount = $transportamount;
        $this->netamount = $netamount;
        $this->vin = $vin;
        $this->licensePlate = $licensePlate;
        $this->nive = $nive;
        $this->acrissCode = $acrissCode;
        $this->color = $color;
        $this->cv = $cv;
        $this->baterycapacity = $baterycapacity;
        $this->tankcapacity = $tankcapacity;
        $this->trunkcapacity = $trunkcapacity;
        $this->actualkms = $actualkms;
        $this->firstRegistrationDate = $firstRegistrationDate;
        $this->lastRegistrationDate = $lastRegistrationDate;
        $this->firstRentDate = $firstRentDate;
        $this->rentingEndDate = $rentingEndDate;
        $this->firstAsssuranceDate = $firstAsssuranceDate;
        $this->vehicleStatusName = $vehicleStatusName;
        $this->actualLocationName = $actualLocationName;
        $this->invoiceAmountWithOutVat = $invoiceAmountWithOutVat;
        $this->invoiceNumber = $invoiceNumber;
        $this->invoiceDate = $invoiceDate;
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

    public function getAnexo1IntRef(): ?string
    {
        return $this->anexo1IntRef;
    }

    public function getSupplierName(): string
    {
        return $this->supplierName;
    }

    public function getBbCustomerName(): ?string
    {
        return $this->bbCustomerName;
    }

    public function getPurchaseTypeName(): string
    {
        return $this->purchaseTypeName;
    }

    public function getPurchaseMethodName(): string
    {
        return $this->purchaseMethodName;
    }

    public function getBrandName(): string
    {
        return $this->brandName;
    }

    public function getModelName(): string
    {
        return $this->modelName;
    }

    public function getTrimName(): string
    {
        return $this->trimName;
    }

    public function getVehicleSalesName(): string
    {
        return $this->vehicleSalesName;
    }

    public function getVehicleGroupName(): string
    {
        return $this->vehicleGroupName;
    }

    public function getVehicleTypeName(): ?string
    {
        return $this->vehicleTypeName;
    }

    public function getNumOfDoors(): int
    {
        return $this->numOfDoors;
    }

    public function getVehicleSeatValue(): string
    {
        return $this->vehicleSeatValue;
    }

    public function getCo2(): ?float
    {
        return $this->co2;
    }

    public function getCarcc(): int
    {
        return $this->carcc;
    }

    public function getGearBoxType(): string
    {
        return $this->gearBoxType;
    }

    public function getMotorTypeName(): string
    {
        return $this->motorTypeName;
    }

    public function getDeliverydate(): string
    {
        return $this->deliverydate;
    }

    public function getReturndate(): string
    {
        return $this->returndate;
    }

    public function getDepreciationPerAmount(): ?float
    {
        return $this->depreciationPerAmount;
    }

    public function getDepreciationmonths(): ?int
    {
        return $this->depreciationmonths;
    }

    public function getInsurancePolicyNumber(): string
    {
        return $this->insurancePolicyNumber;
    }

    public function getInsurancePolicyCompanyId(): string
    {
        return $this->insurancePolicyCompanyId;
    }

    public function getInsuranceActivationDate(): ?string
    {
        return $this->insuranceActivationDate;
    }

    public function getInsuranceFinishDate(): ?string
    {
        return $this->insuranceFinishDate;
    }

    public function getAverageDamageAmount(): ?float
    {
        return $this->averageDamageAmount;
    }

    public function getAverageMileage(): ?int
    {
        return $this->averageMileage;
    }

    public function getAverageRegistrationDate(): ?string
    {
        return $this->averageRegistrationDate;
    }

    public function getReceptionLocationName(): string
    {
        return $this->receptionLocationName;
    }

    public function getForfait(): ?float
    {
        return $this->forfait;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getInteriorHeight(): ?int
    {
        return $this->interiorHeight;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getInteriorWidth(): ?int
    {
        return $this->interiorWidth;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function getInteriorLength(): ?int
    {
        return $this->interiorLength;
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

    public function getOptionsamount(): ?float
    {
        return $this->optionsamount;
    }

    public function getPurchasediscount(): ?float
    {
        return $this->purchasediscount;
    }

    public function getTransportamount(): ?float
    {
        return $this->transportamount;
    }

    public function getNetamount(): float
    {
        return $this->netamount;
    }

    public function getVin(): string
    {
        return $this->vin;
    }

    public function getLicensePlate(): ?string
    {
        return $this->licensePlate;
    }

    public function getNive(): ?string
    {
        return $this->nive;
    }

    public function getAcrissCode(): string
    {
        return $this->acrissCode;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getCv(): string
    {
        return $this->cv;
    }

    public function getBaterycapacity(): ?string
    {
        return $this->baterycapacity;
    }

    public function getTankcapacity(): ?string
    {
        return $this->tankcapacity;
    }

    public function getTrunkcapacity(): ?string
    {
        return $this->trunkcapacity;
    }

    public function getActualkms(): ?string
    {
        return $this->actualkms;
    }

    public function getFirstRegistrationDate(): ?string
    {
        return $this->firstRegistrationDate;
    }

    public function getLastRegistrationDate(): ?string
    {
        return $this->lastRegistrationDate;
    }

    public function getFirstRentDate(): string
    {
        return $this->firstRentDate;
    }

    public function getRentingEndDate(): string
    {
        return $this->rentingEndDate;
    }

    public function getFirstAsssuranceDate(): ?string
    {
        return $this->firstAsssuranceDate;
    }

    public function getVehicleStatusName(): string
    {
        return $this->vehicleStatusName;
    }

    public function getActualLocationName(): ?string
    {
        return $this->actualLocationName;
    }

    public function getInvoiceAmountWithOutVat(): ?float
    {
        return $this->invoiceAmountWithOutVat;
    }

    public function getInvoiceNumber(): ?string
    {
        return $this->invoiceNumber;
    }

    public function getInvoiceDate(): ?string
    {
        return $this->invoiceDate;
    }

    public function getAccountingDate(): ?string
    {
        return $this->accountingDate;
    }

    public function getCapAmount(): ?string
    {
        return $this->capAmount;
    }

    public function getFixedAssetRegistrationDate(): ?string
    {
        return $this->fixedAssetRegistrationDate;
    }

    public function getFixedAssetClass(): ?string
    {
        return $this->fixedAssetClass;
    }

    public function getAmortizationStartDate(): ?string
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
     * @param array $fleetImport
     * @return array
     */
    public static function mapper(array $fleetImport): array
    {
        return [
            'VIN' => $fleetImport['vin'],
            'LICENSEPLATE' => $fleetImport['licensePlate'],
            // 'ANEXO1INTREF' => $fleetImport['anexo1IntRef'],
            'PROVIDERID' => $fleetImport['providerSAPId'],
            'PURCHASEMETHODID' => $fleetImport['saleMethod'],
            'SALEMETHODID' => $fleetImport['saleMethod'],
            'PURCHASETYPEID' => $fleetImport['purchaseType'],
            'BBCUSTOMERID' => $fleetImport['customerSAPId'],
            'VEHICLESALESNAME' => $fleetImport['vehicleSalesName'],
            'TRIMID' => $fleetImport['trimId'],
            'CARCC' => $fleetImport['carCC'],
            'CV' => $fleetImport['cv'],
            'MOTORTYPEID' => $fleetImport['motorizationType'],
            'MOTORCAPACITY' => $fleetImport['motor'],
            'MOTORDESIGNATION' => $fleetImport['motorDenomination'],
            'MOTORKW' => $fleetImport['kw'],
            'GEARBOXID' => $fleetImport['gearBox'],
            'COLOR' => $fleetImport['color'],
            'MIRCOLORSID' => $fleetImport['colorMIR'],
            'CO2' => $fleetImport['co2'],
            'NUMOFDOORS' => $fleetImport['numberOfDoors'],
            'VEHICLESEATSID' => $fleetImport['vehicleSeats'],
            'TANKCAPACITY' => $fleetImport['tankCapacity'],
            'TRUNKCAPACITY' => $fleetImport['trunkCapacity'],
            'BATERYCAPACITY' => $fleetImport['batteryCapacity'],
            'HEIGHT' => $fleetImport['height'],
            'INTERIORHEIGHT' => $fleetImport['interiorHeight'],
            'WIDTH' => $fleetImport['width'],
            'INTERIORWIDTH' => $fleetImport['interiorWidth'],
            'LENGTH' => $fleetImport['length'],
            'INTERIORLENGTH' => $fleetImport['interiorLength'],
            'NIVE' => $fleetImport['nive'],
            'FIRSTREGISTRATIONDATE' => $fleetImport['firstRegistrationDate'] ? Utils::formatTimestampToOdataDate($fleetImport['firstRegistrationDate']) : null,
            'LASTREGISTRATIONDATE' => $fleetImport['lastRegistrationDate'] ? Utils::formatTimestampToOdataDate($fleetImport['lastRegistrationDate']) : null,
            'VEHICLEGROUPID' => $fleetImport['vehicleGroup'],
            'VEHICLETYPEID' => $fleetImport['vehicleType'],
            'ACRISSID' => $fleetImport['acriss'],
            'AVERAGEDAMAGEAMOUNT' => $fleetImport['averageDamageAmount'],
            'STARTKMS' => $fleetImport['initialKms'],
            'DELIVERYDATE' => $fleetImport['deliveryDate'] ? Utils::formatTimestampToOdataDate($fleetImport['deliveryDate']) : null,
            'FIRSTRENTDATE' => $fleetImport['firstRentDate'] ? Utils::formatTimestampToOdataDate($fleetImport['firstRentDate']) : null,
            'RENTINGENDDATE' => $fleetImport['rentingEndDate'] ? Utils::formatTimestampToOdataDate($fleetImport['rentingEndDate']) : null,
            'RETURNDATE' => $fleetImport['returnDate'] ? Utils::formatTimestampToOdataDate($fleetImport['returnDate']) : null,
            'RECEPTIONLOCATIONID' => $fleetImport['receptionLocation'],
            'ACTUALLOCATIONID' => $fleetImport['actualLocation'],
            'FORFAIT' => $fleetImport['forfait'],
            'EXCESS' => $fleetImport['excess'],
            'HOLDINGPERIOD' => $fleetImport['holdingPeriod'],
            'DEPRECIATIONPERAMOUNT' => $fleetImport['depreciationPerAmount'],
            'DEPRECIATIONMONTHS' => $fleetImport['depreciationMonths'],
            'STATUSID' => $fleetImport['vehicleStatus'] ?? ConstantsJsonFile::getValue('CARSTATUS_NEW_VIN'),
            'ACTUALKMS' => $fleetImport["actualKms"] ?? $fleetImport['initialKms'],
            'INSURANCEPOLICYCOMPANYID' => $fleetImport['insurancePolicyProviderSAPId'],
            'INSURANCEPOLICYNUMBER' => $fleetImport['policyNumber'],
            'INSURANCEACTIVATIONDATE' => $fleetImport['activationDate'] ? Utils::formatTimestampToOdataDate($fleetImport['activationDate']) : null,
            'DEACTIVATIONDATE' => $fleetImport['deactivationDate'] ? Utils::formatTimestampToOdataDate($fleetImport['deactivationDate']) : null,
            'INSURANCEFINISHDATE' => $fleetImport['finishDate'] ? Utils::formatTimestampToOdataDate($fleetImport['finishDate']) : null,
            'MINHOLDINGPERIODAMOUNT' => $fleetImport['minHoldingPeriodAmount'],
            'MINHOLDINGPERIODKM' => $fleetImport['minHoldingPeriodKm'],
            'PFFAMOUNT' => $fleetImport['pffAmount'],
            'OPTIONSAMOUNT' => $fleetImport['optionsAmount'],
            'PURCHASEDISCOUNT' => $fleetImport['purchaseDiscount'],
            'TRANSPORTAMOUNT' => $fleetImport['transportAmount'],
            'NETAMOUNT' => $fleetImport['netAmount'],
            'CREATIONDATE' => $fleetImport['creationDate'] ? Utils::formatTimestampToOdataDate($fleetImport['creationDate']) : null,


            // Campos suprimidos
            // 'AVERAGEREGISTRATIONDATE' => $fleetImport['averageRegistrationDate'] ? Utils::formatTimestampToOdataDate($fleetImport['averageRegistrationDate']):null,
            // 'MONTHLYFEE' => $fleetImport['monthlyFee'],
            // 'INVOICENUMBER' => $fleetImport['invoiceNumber'],
            // 'INVOICEDATE' => $fleetImport['invoiceDate'] ? Utils::formatTimestampToOdataDate($fleetImport['invoiceDate']) : null,
            // 'INVOICEAMOUNTWITHOUTVAT' => $fleetImport['invoiceAmountWhitoutVat'],
            // 'ACCOUNTINGDATE' => $fleetImport['accountingDate'] ? Utils::formatTimestampToOdataDate($fleetImport['accountingDate']) : null,
            // 'CAPAMOUNT' => $fleetImport['capAmount'],
            // 'TAXUNITAMOUNT' => $fleetImport['taxUnitAmount'],
            // 'FIXEDASSETREGISTRATIONDATE' => $fleetImport['fixedAssetRegistrationDate'] ? Utils::formatTimestampToOdataDate($fleetImport['fixedAssetRegistrationDate']) : null,
            // 'FIXEDASSETCLASS' => $fleetImport['fixedAssetClass'],
            // 'AMORTIZATIONSTARTDATE' => $fleetImport['amortizationStartDate'] ? Utils::formatTimestampToOdataDate($fleetImport['amortizationStartDate']) : null,
            // 'AMORTIZATIONCLASS' => $fleetImport['amortizationClass'],
            // 'FINANCINGTYPE' => $fleetImport['financingType'],
            // 'FROMTHIRDPARTIES' => $fleetImport['fromThirdParties'],
            // 'LEASEPERCENTAGE' => $fleetImport['leasePercentage'],
            // 'REPURCHASEMONTHS' => $fleetImport['repurchaseMonths'],
            // 'BUSINESSUNIT' => $fleetImport['businessUnit'],
            // 'AREA' => $fleetImport['area'],
            // 'PROVISIONGENERATES' => $fleetImport['provisionGenerates'],
        ];
    }
}
