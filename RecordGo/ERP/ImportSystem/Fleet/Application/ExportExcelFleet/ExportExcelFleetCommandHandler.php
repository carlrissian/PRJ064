<?php

namespace ImportSystem\Fleet\Application\ExportExcelFleet;

use Shared\Utils\Utils;
use ImportSystem\Trim\Domain\Trim;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Pagination\Sort;
use ImportSystem\Fleet\Domain\Fleet;
use ImportSystem\Acriss\Domain\Acriss;
use ImportSystem\GearBox\Domain\GearBox;
use Shared\Domain\Pagination\Pagination;
use ImportSystem\CarGroup\Domain\CarGroup;
use ImportSystem\Location\Domain\Location;
use ImportSystem\Provider\Domain\Provider;
use ImportSystem\Trim\Domain\TrimCriteria;
use Shared\Domain\Criteria\FilterOperator;
use ImportSystem\Fleet\Domain\FleetCriteria;
use ImportSystem\Trim\Domain\TrimRepository;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Pagination\SortCollection;
use ImportSystem\Fleet\Domain\FileRepository;
use ImportSystem\Acriss\Domain\AcrissCriteria;
use ImportSystem\Fleet\Domain\FleetRepository;
use ImportSystem\SaleMethod\Domain\SaleMethod;
use ImportSystem\Acriss\Domain\AcrissRepository;
use ImportSystem\Fleet\Domain\FleetExcelColumns;
use ImportSystem\GearBox\Domain\GearBoxCriteria;
use ImportSystem\VehicleType\Domain\VehicleType;
use ImportSystem\CarGroup\Domain\CarGroupCriteria;
use ImportSystem\ColorMIR\Domain\ColorMIRCriteria;
use ImportSystem\GearBox\Domain\GearBoxRepository;
use ImportSystem\Location\Domain\LocationCriteria;
use ImportSystem\Provider\Domain\ProviderCriteria;
use ImportSystem\PurchaseType\Domain\PurchaseType;
use ImportSystem\CarGroup\Domain\CarGroupRepository;
use ImportSystem\ColorMIR\Domain\ColorMIRRepository;
use ImportSystem\Location\Domain\LocationRepository;
use ImportSystem\Provider\Domain\ProviderRepository;
use ImportSystem\VehicleStatus\Domain\VehicleStatus;
use ImportSystem\SaleMethod\Domain\SaleMethodCriteria;
use ImportSystem\SaleMethod\Domain\SaleMethodRepository;
use ImportSystem\VehicleType\Domain\VehicleTypeCriteria;
use ImportSystem\PurchaseType\Domain\PurchaseTypeCriteria;
use ImportSystem\VehicleType\Domain\VehicleTypeRepository;
use ImportSystem\PurchaseType\Domain\PurchaseTypeRepository;
use ImportSystem\VehicleStatus\Domain\VehicleStatusCriteria;
use ImportSystem\VehicleStatus\Domain\VehicleStatusRepository;
use ImportSystem\MotorizationType\Domain\MotorizationTypeCriteria;
use ImportSystem\MotorizationType\Domain\MotorizationTypeRepository;
use ImportSystem\VehicleSeats\Domain\VehicleSeats;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsCriteria;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsRepository;

class ExportExcelFleetCommandHandler
{
    /**
     * @var FleetRepository $fleetRepository
     */
    private FleetRepository $fleetRepository;

    /**
     * @var FileRepository $fileRepository
     */
    private FileRepository $fileRepository;


    /**
     * @var ProviderRepository $providerRepository
     */
    private $providerRepository;

    /**
     * @var SaleMethodRepository $saleMethodRepository
     */
    private $saleMethodRepository;

    /**
     * @var PurchaseTypeRepository $purchaseTypeRepository
     */
    private $purchaseTypeRepository;

    /**
     * @var TrimRepository $trimRepository
     */
    private $trimRepository;

    /**
     * @var MotorizationTypeRepository $motorizationTypeRepository
     */
    private $motorizationTypeRepository;

    /**
     * @var GearBoxRepository $gearBoxRepository
     */
    private $gearBoxRepository;

    /**
     * @var ColorMIRRepository $colorMIRRepository
     */
    private $colorMIRRepository;

    /**
     * @var VehicleSeatsRepository $vehicleSeatsRepository
     */
    private $vehicleSeatsRepository;

    /**
     * @var VehicleTypeRepository $vehicleTypeRepository
     */
    private $vehicleTypeRepository;

    /**
     * @var CarGroupRepository $vehicleGroupRepository
     */
    private $vehicleGroupRepository;

    /**
     * @var AcrissRepository $acrissRepository
     */
    private $acrissRepository;

    /**
     * @var LocationRepository $locationRepository
     */
    private $locationRepository;

    /**
     * @var VehicleStatusRepository $vehicleStatusRepository
     */
    private $vehicleStatusRepository;

    /**
     * @param FleetRepository $fleetRepository
     * @param FileRepository $fileRepository
     * @param ProviderRepository $providerRepository
     * @param SaleMethodRepository $saleMethodRepository
     * @param PurchaseTypeRepository $purchaseTypeRepository
     * @param TrimRepository $trimRepository
     * @param MotorizationTypeRepository $motorizationTypeRepository
     * @param GearBoxRepository $gearBoxRepository
     * @param ColorMIRRepository $colorMIRRepository
     * @param VehicleSeatsRepository $vehicleSeatsRepository
     * @param VehicleTypeRepository $vehicleTypeRepository
     * @param CarGroupRepository $vehicleGroupRepository
     * @param AcrissRepository $acrissRepository
     * @param LocationRepository $locationRepository
     * @param VehicleStatusRepository $vehicleStatusRepository
     */
    public function __construct(
        FleetRepository $fleetRepository,
        FileRepository $fileRepository,
        ProviderRepository $providerRepository,
        SaleMethodRepository $saleMethodRepository,
        PurchaseTypeRepository $purchaseTypeRepository,
        TrimRepository $trimRepository,
        MotorizationTypeRepository $motorizationTypeRepository,
        GearBoxRepository $gearBoxRepository,
        ColorMIRRepository $colorMIRRepository,
        VehicleSeatsRepository $vehicleSeatsRepository,
        VehicleTypeRepository $vehicleTypeRepository,
        CarGroupRepository $vehicleGroupRepository,
        AcrissRepository $acrissRepository,
        LocationRepository $locationRepository,
        VehicleStatusRepository $vehicleStatusRepository
    ) {
        $this->fleetRepository = $fleetRepository;
        $this->fileRepository = $fileRepository;
        $this->providerRepository = $providerRepository;
        $this->saleMethodRepository = $saleMethodRepository;
        $this->purchaseTypeRepository = $purchaseTypeRepository;
        $this->trimRepository = $trimRepository;
        $this->motorizationTypeRepository = $motorizationTypeRepository;
        $this->gearBoxRepository = $gearBoxRepository;
        $this->colorMIRRepository = $colorMIRRepository;
        $this->vehicleSeatsRepository = $vehicleSeatsRepository;
        $this->vehicleTypeRepository = $vehicleTypeRepository;
        $this->vehicleGroupRepository = $vehicleGroupRepository;
        $this->acrissRepository = $acrissRepository;
        $this->locationRepository = $locationRepository;
        $this->vehicleStatusRepository = $vehicleStatusRepository;
    }

    /**
     * @param ExportExcelFleetCommand $command
     * @return ExportExcelFleetResponse
     */
    public function handle(ExportExcelFleetCommand $command): ExportExcelFleetResponse
    {
        $criteria = $this->setCriteria($command);
        $fleetCollection = $this->fleetRepository->export($criteria);

        $dropdownLists = $this->setDropDownList();

        $fleetList = [];
        /**
         * @var Fleet $fleet
         */
        foreach ($fleetCollection as $fleet) {
            $fleetList[] = [
                [
                    "title" => FleetExcelColumns::getNameById('vin'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getVin() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('licensePlate'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getLicensePlate() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('anexo1Year'),
                    "value" => $fleet->getAnexo1Head() !== null ? $fleet->getAnexo1Head()->getAnexo1Year() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('anexo1IntRef'),
                    "value" => $fleet->getAnexo1Head() !== null ? $fleet->getAnexo1Head()->getAnexo1IntRef() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('modelcode'),
                    // "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getModelCode() !== null
                    //     ? $fleet->getVehicle()->getModelCode()
                    //     : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getModelCode() : null),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getModelCode() !== null ? $fleet->getVehicle()->getModelCode() : null,
                ],
                [
                    "title" => FleetExcelColumns::getNameById('providerSAPId'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getProvider() !== null
                        ? sprintf("%s | %s", $fleet->getVehicle()->getProvider()->getProviderSAPId(), $fleet->getVehicle()->getProvider()->getName())
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getProvider() !== null
                            ? sprintf("%s | %s", $fleet->getAnexoLine()->getProvider()->getProviderSAPId(), $fleet->getAnexoLine()->getProvider()->getName())
                            : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('saleMethod'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getSaleMethod() !== null ? $fleet->getVehicle()->getSaleMethod()->getName() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('purchaseType'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getPurchaseType() !== null
                        ? $fleet->getVehicle()->getPurchaseType()->getName()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getPurchaseType() !== null ? $fleet->getAnexoLine()->getPurchaseType()->getName() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('customerSAPId'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getBbCustomer() !== null
                        ? sprintf("%s | %s", $fleet->getVehicle()->getBbCustomer()->getCustomerSAPId(), $fleet->getVehicle()->getBbCustomer()->getName())
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getBbCustomer() !== null
                            ? sprintf("%s | %s", $fleet->getAnexoLine()->getBbCustomer()->getCustomerSAPId(), $fleet->getAnexoLine()->getBbCustomer()->getName())
                            : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('vehicleSalesName'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getVehicleSalesName() !== null
                        ? $fleet->getVehicle()->getVehicleSalesName()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getVehicleSalesName() : null)
                ],
                //For brand first look to anexoline and then to vehicle
                [
                    "title" => FleetExcelColumns::getNameById('brand'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getBrand() !== null
                        ? $fleet->getVehicle()->getBrand()->getName()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getBrand() !== null ? $fleet->getAnexoLine()->getBrand()->getName() : null)
                ],
                //For model first look to anexoline and then to vehicle
                [
                    "title" => FleetExcelColumns::getNameById('model'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getModel() !== null
                        ? $fleet->getVehicle()->getModel()->getName()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getModel() !== null ? $fleet->getAnexoLine()->getModel()->getName() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('trim'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getTrim() !== null
                        ? $fleet->getVehicle()->getTrim()->getName()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getTrim() !== null ? $fleet->getAnexoLine()->getTrim()->getName() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('trimId'),
                    "value" => $fleet->getVehicle() !== null
                        ? sprintf(
                            "%s | %s %s %s",
                            $fleet->getVehicle()->getTrim() ? $fleet->getVehicle()->getTrim()->getId() : null,
                            $fleet->getVehicle()->getBrand() ? $fleet->getVehicle()->getBrand()->getName() : null,
                            $fleet->getVehicle()->getModel() ? $fleet->getVehicle()->getModel()->getName() : null,
                            $fleet->getVehicle()->getTrim() ? $fleet->getVehicle()->getTrim()->getName() : null
                        )
                        : ($fleet->getAnexoLine() !== null
                            ? sprintf(
                                "%s | %s %s %s",
                                $fleet->getAnexoLine()->getTrim() ? $fleet->getAnexoLine()->getTrim()->getId() : null,
                                $fleet->getAnexoLine()->getBrand() ? $fleet->getAnexoLine()->getBrand()->getName() : null,
                                $fleet->getAnexoLine()->getModel() ? $fleet->getAnexoLine()->getModel()->getName() : null,
                                $fleet->getAnexoLine()->getTrim() ? $fleet->getAnexoLine()->getTrim()->getName() : null
                            )
                            : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('carCC'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getCarcc() !== null
                        ? $fleet->getVehicle()->getCarcc()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getCarcc() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('cv'),
                    "title" => "CV",
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getCv() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('motorizationType'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getMotorType() !== null
                        ? $fleet->getVehicle()->getMotorType()->getName()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getMotorType() !== null ? $fleet->getAnexoLine()->getMotorType()->getName() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('motor'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getMotor() !== null
                        ? $fleet->getVehicle()->getMotor()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getMotor() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('motorDenomination'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getMotorDenomination() !== null
                        ? $fleet->getVehicle()->getMotorDenomination()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getMotorDenomination() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('kw'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getKw() !== null
                        ? $fleet->getVehicle()->getKw()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getKw() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('gearBox'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getGearBox() !== null
                        ? $fleet->getVehicle()->getGearBox()->getType()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getGearBox() !== null ? $fleet->getAnexoLine()->getGearBox()->getType() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('color'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getColor() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('colorMIR'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getColorMIR() !== null
                        ? $fleet->getVehicle()->getColorMIR()->getName()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getColorMIR() !== null ? $fleet->getAnexoLine()->getColorMIR()->getName() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('co2'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getCo2() !== null
                        ? $fleet->getVehicle()->getCo2()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getCo2() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('numberOfDoors'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getNumOfDoors() !== null
                        ? $fleet->getVehicle()->getNumOfDoors()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getNumOfDoors() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('vehicleSeats'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getVehicleSeats() !== null
                        ? $fleet->getVehicle()->getVehicleSeats()->getValue()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getVehicleSeats() !== null ? $fleet->getAnexoLine()->getVehicleSeats()->getValue() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('tankCapacity'),
                    "value" =>  $fleet->getVehicle() !== null ? $fleet->getVehicle()->getTankCapacity() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('trunkCapacity'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getTrunkCapacity() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('batteryCapacity'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getBateryCapacity() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('height'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getHeight() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('interiorHeight'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getInteriorHeight() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('width'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getWidth() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('interiorWidth'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getInteriorWidth() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('length'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getLength() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('interiorLength'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getInteriorLength() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('nive'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getNive() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('firstRegistrationDate'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getFirstRegistrationDate() !== null ? $fleet->getVehicle()->getFirstRegistrationDate()->__toString('d/m/Y') : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('lastRegistrationDate'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getLastRegistrationDate() !== null ? $fleet->getVehicle()->getLastRegistrationDate()->__toString('d/m/Y') : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('vehicleGroup'),
                    "value" => $fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getVehicleGroup() !== null
                        ? $fleet->getAnexoLine()->getVehicleGroup()->getName()
                        : ($fleet->getVehicle() !== null && $fleet->getVehicle()->getVehicleGroup() !== null ? $fleet->getVehicle()->getVehicleGroup()->getName() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('vehicleType'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getVehicleType() !== null
                        ? $fleet->getVehicle()->getVehicleType()->getName()
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getVehicleType() !== null ? $fleet->getAnexoLine()->getVehicleType()->getName() : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('acriss'),
                    "value" => $fleet->getVehicle() !== null
                        ? sprintf(
                            "%s (%s)",
                            $fleet->getVehicle()->getAcriss() !== null ? $fleet->getVehicle()->getAcriss()->getName() : null,
                            $fleet->getVehicle()->getVehicleGroup() !== null ? $fleet->getVehicle()->getVehicleGroup()->getName() : null
                        )
                        : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('averageDamageAmount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getAverageDamageAmount() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('initialKms'),
                    "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getInitialKms() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('deliveryDate'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getDeliveryDate() !== null
                        ? $fleet->getVehicle()->getDeliveryDate()->__toString('d/m/Y')
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getDeliveryDate() !== null ? $fleet->getAnexoLine()->getDeliveryDate()->__toString('d/m/Y') : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('firstRentDate'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getFirstRentDate() !== null ? $fleet->getVehicle()->getFirstRentDate()->__toString('d/m/Y') : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('rentingEndDate'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getRentingEndDate() !== null ? $fleet->getVehicle()->getRentingEndDate()->__toString('d/m/Y') : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('returnDate'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getReturnDate() !== null
                        ? $fleet->getVehicle()->getReturnDate()->__toString('d/m/Y')
                        : ($fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getReturnDate() !== null ? $fleet->getAnexoLine()->getReturnDate()->__toString('d/m/Y') : null)
                ],
                [
                    "title" => FleetExcelColumns::getNameById('receptionLocation'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getReceptionLocation() !== null ? $fleet->getVehicle()->getReceptionLocation()->getName() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('actualLocation'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getActualLocation() !== null ? $fleet->getVehicle()->getActualLocation()->getName() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('forfait'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getForfait() !== null
                        ? $fleet->getVehicle()->getForfait()
                        : ($fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getForfait() : null)
                ],

                [
                    "title" => FleetExcelColumns::getNameById('excess'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getExcess() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('holdingPeriod'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getHoldingPeriod() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('depreciationPerAmount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getDepreciationPerAmount() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('depreciationMonths'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getDepreciationMonths() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('vehicleStatus'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getVehicleStatus() !== null ? $fleet->getVehicle()->getVehicleStatus()->getName() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('actualKms'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getActualKms() !== null ? $fleet->getVehicle()->getActualKms() : $fleet->getVehicle()->getInitialKms()
                ],
                [
                    "title" => FleetExcelColumns::getNameById('insurancePolicyProviderSAPId'),
                    "value" => $fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getCertificate() !== null && $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy() !== null && $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getPolicyCompany() !== null
                        ? sprintf(
                            "%s | %s",
                            $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getPolicyCompany()->getProviderSAPId(),
                            $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getPolicyCompany()->getName()
                        )
                        : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('policyNumber'),
                    "value" => $fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getCertificate() !== null && $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy() !== null
                        ? $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getPolicyNumber() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('activationDate'),
                    "value" => $fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getCertificate() !== null ?
                        ($fleet->getAnexoLine()->getCertificate()->getInsurancePolicy() !== null && $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getActivationDate() !== null ?
                            $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getActivationDate()->__toString('d/m/Y')
                            : ($fleet->getAnexoLine()->getCertificate()->getActivationDate() !== null ? $fleet->getAnexoLine()->getCertificate()->getActivationDate()->__toString('d/m/Y') : null))
                        : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('cancelationDate'),
                    "value" => $fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getCertificate() !== null ?
                        ($fleet->getAnexoLine()->getCertificate()->getInsurancePolicy() !== null && $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getDeactivationDate() !== null ?
                            $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getDeactivationDate()->__toString('d/m/Y')
                            : ($fleet->getAnexoLine()->getCertificate()->getDeactivationDate() !== null ? $fleet->getAnexoLine()->getCertificate()->getDeactivationDate()->__toString('d/m/Y') : null))
                        : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('finishDate'),
                    "value" => $fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getCertificate() !== null ?
                        ($fleet->getAnexoLine()->getCertificate()->getInsurancePolicy() !== null && $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getFinishDate() !== null ?
                            $fleet->getAnexoLine()->getCertificate()->getInsurancePolicy()->getFinishDate()->__toString('d/m/Y')
                            : ($fleet->getAnexoLine()->getCertificate()->getFinishDate() !== null ? $fleet->getAnexoLine()->getCertificate()->getFinishDate()->__toString('d/m/Y') : null))
                        : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('minHoldingPeriodAmount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getMinHoldingPeriodAmount() : null
                ],
                // No hay parametro en anexolines aun
                [
                    "title" => FleetExcelColumns::getNameById('minHoldingPeriodKm'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getMinHoldingPeriodKm() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('pffAmount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getPffAmount() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('optionsAmount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getOptionsAmount() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('purchaseDiscount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getPurchaseDiscount() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('transportAmount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getTransportAmount() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('netAmount'),
                    "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getNetAmount() : null
                ],
                [
                    "title" => FleetExcelColumns::getNameById('creationDate'),
                    "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getCreationDate() !== null ? $fleet->getVehicle()->getCreationDate()->__toString('d/m/Y') : null
                ],


                // Campos suprimidos
                // [
                //     "title" "> FleetExcelColumns::getNameById('averageRegistrationDate'),
                //     "value" => $fleet->getAnexoLine() !== null && $fleet->getAnexoLine()->getAverageRegistrationDate() !== null ? $fleet->getAnexoLine()->getAverageRegistrationDate()->__toString('d/m/Y') : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('monthlyFee'),
                //     "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getMonthlyFee() : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('invoiceNumber'),
                //     "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getInvoiceNumber() : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('invoiceDate'),
                //     "value" => $fleet->getVehicle() !== null && $fleet->getVehicle()->getInvoiceDate() !== null ? $fleet->getVehicle()->getInvoiceDate()->__toString('d/m/Y') : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('invoiceAmountWhitoutVat'),
                //     "value" => $fleet->getVehicle() !== null ? $fleet->getVehicle()->getInvoiceAmountWithOutVat() : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('accountingDate'),
                //     "value" => $fleet->getAccountingDate() !== null ? $fleet->getAccountingDate()->__toString('d/m/Y') : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('capAmount'),
                //     "value" => $fleet->getCapAmount()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('taxUnitAmount'),
                //     "value" => $fleet->getAnexoLine() !== null ? $fleet->getAnexoLine()->getTaxUnitAmount() : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('fixedAssetRegistrationDate'),
                //     "value" => $fleet->getFixedAssetRegistrationDate() !== null ? $fleet->getFixedAssetRegistrationDate()->__toString('d/m/Y') : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('fixedAssetClass'),
                //     "value" => $fleet->getFixedAssetClass()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('amortizationStartDate'),
                //     "value" => $fleet->getAmortizationStartDate() !== null ? $fleet->getAmortizationStartDate()->__toString('d/m/Y') : null
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('amortizationClass'),
                //     "value" => $fleet->getAmortizationClass()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('financingType'),
                //     "value" => $fleet->getFinancingType()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('fromThirdParties'),
                //     "value" => $fleet->getFromThirdParties()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('leasePercentage'),
                //     "value" => $fleet->getLeasePercentage()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('repurchaseMonths'),
                //     "value" => $fleet->getRepurchaseMonths()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('businessUnit'),
                //     "value" => $fleet->getBusinessUnit()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('area'),
                //     "value" => $fleet->getArea()
                // ],
                // [
                //     "title" => FleetExcelColumns::getNameById('provisionGenerates'),
                //     "value" => $fleet->getProvisionGenerates()
                // ]
            ];
        }

        [$tempFile, $fileName] = $this->fileRepository->export($fleetList, $dropdownLists);

        return new ExportExcelFleetResponse($tempFile, $fileName);
    }


    /**
     * @param ExportExcelFleetCommand $command
     * @return FleetCriteria
     */
    private function setCriteria(ExportExcelFleetCommand $command): FleetCriteria
    {
        $filterCollection = new FilterCollection([]);

        if ($command->getProviderIdIn()) $filterCollection->add(new Filter('PROVIDERIDIN', new FilterOperator(FilterOperator::IN), $command->getProviderIdIn()));

        if ($command->getBbCustomerIdIn()) $filterCollection->add(new Filter('BBCUSTOMERIDIN', new FilterOperator(FilterOperator::IN), $command->getBbCustomerIdIn()));

        if ($command->getPurchaseTypeIdIn()) $filterCollection->add(new Filter('PURCHASETYPEIDIN', new FilterOperator(FilterOperator::IN), $command->getPurchaseTypeIdIn()));

        if ($command->getSaleMethodIdIn()) $filterCollection->add(new Filter('SALEMETHODIDIN', new FilterOperator(FilterOperator::IN), $command->getSaleMethodIdIn()));

        if ($command->getBrandIdIn()) $filterCollection->add(new Filter('BRANDIDIN', new FilterOperator(FilterOperator::IN), $command->getBrandIdIn()));

        if ($command->getModelIdIn()) $filterCollection->add(new Filter('MODELIDIN', new FilterOperator(FilterOperator::IN), $command->getModelIdIn()));

        if ($command->getTrimIdIn()) $filterCollection->add(new Filter('TRIMIDIN', new FilterOperator(FilterOperator::IN), $command->getTrimIdIn()));

        if ($command->getCarGroupIdIn()) $filterCollection->add(new Filter('CARGROUPIDIN', new FilterOperator(FilterOperator::IN), $command->getCarGroupIdIn()));

        if ($command->getVehicleTypeIdIn()) $filterCollection->add(new Filter('VEHICLETYPEIDIN', new FilterOperator(FilterOperator::IN), $command->getVehicleTypeIdIn()));

        if ($command->getAcrissIdIn()) $filterCollection->add(new Filter('ACRISSIDIN', new FilterOperator(FilterOperator::IN), $command->getAcrissIdIn()));

        if ($command->getGearBoxIdIn()) $filterCollection->add(new Filter('GEARBOXIDIN', new FilterOperator(FilterOperator::IN), $command->getGearBoxIdIn()));

        if ($command->getMotorizationTypeIdIn()) $filterCollection->add(new Filter('MOTORIZATIONTYPEIDIN', new FilterOperator(FilterOperator::IN), $command->getMotorizationTypeIdIn()));

        if ($command->getReceptionLocationIdIn()) $filterCollection->add(new Filter('RECEPTIONLOCATIONIDIN', new FilterOperator(FilterOperator::IN), $command->getReceptionLocationIdIn()));

        if ($command->getVehicleStatusIdIn()) $filterCollection->add(new Filter('VEHICLESTATUSIDIN', new FilterOperator(FilterOperator::IN), $command->getVehicleStatusIdIn()));

        if ($command->getActualLocationIdIn()) $filterCollection->add(new Filter('ACTUALLOCATIONIDIN', new FilterOperator(FilterOperator::IN), $command->getActualLocationIdIn()));


        if ($command->getFirstRegistrationDateFrom()) $filterCollection->add(new Filter('FIRSTREGISTRATIONDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getFirstRegistrationDateFrom())));
        if ($command->getFirstRegistrationDateTo()) $filterCollection->add(new Filter('FIRSTREGISTRATIONDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($command->getFirstRegistrationDateTo())));

        if ($command->getLastRegistrationDateFrom()) $filterCollection->add(new Filter('LASTREGISTRATIONDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getLastRegistrationDateFrom())));
        if ($command->getLastRegistrationDateTo()) $filterCollection->add(new Filter('LASTREGISTRATIONDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($command->getLastRegistrationDateTo())));

        if ($command->getDeliveryDateFrom()) $filterCollection->add(new Filter('DELIVERYDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getDeliveryDateFrom())));
        if ($command->getDeliveryDateTo()) $filterCollection->add(new Filter('DELIVERYDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($command->getDeliveryDateTo())));

        if ($command->getReturnDateFrom()) $filterCollection->add(new Filter('RETURNDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getReturnDateFrom())));
        if ($command->getReturnDateTo()) $filterCollection->add(new Filter('RETURNDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($command->getReturnDateTo())));

        if ($command->getFirstRentDateFrom()) $filterCollection->add(new Filter('FIRSTRENTDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getFirstRentDateFrom())));
        if ($command->getFirstRentDateTo()) $filterCollection->add(new Filter('FIRSTRENTDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($command->getFirstRentDateTo())));

        if ($command->getRentingEndDateFrom()) $filterCollection->add(new Filter('RENTINGENDDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getRentingEndDateFrom())));
        if ($command->getRentingEndDateTo()) $filterCollection->add(new Filter('RENTINGENDDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($command->getRentingEndDateTo())));

        if ($command->getCreationDateFrom()) $filterCollection->add(new Filter('CREATIONDATEFROM', new FilterOperator(FilterOperator::GREATER_EQUAL_THAN), Utils::formatDateToFirstMinuteDateTime($command->getCreationDateFrom())));
        if ($command->getCreationDateTo()) $filterCollection->add(new Filter('CREATIONDATETO', new FilterOperator(FilterOperator::LESS_EQUAL_THAN),  Utils::formatDateToLastMinuteDateTime($command->getCreationDateTo())));


        if ($command->isOnlyOperative()) $filterCollection->add(new Filter('HASLICENSEPLATE', new FilterOperator(FilterOperator::EQUAL), 1));
        if ($command->isWithoutLicensePlate()) $filterCollection->add(new Filter('HASLICENSEPLATE', new FilterOperator(FilterOperator::EQUAL), 0));


        // $sortCollection = null;
        // if (!empty($command->getSort()) && !empty($command->getOrder())) {
        //     $sortCollection = new SortCollection([
        //         new Sort($command->getSort(), $command->getOrder())
        //     ]);
        // }
        // $pagination = new Pagination($command->getLimit(), $command->getOffset(), $sortCollection);
        // $criteria = new FleetCriteria($filterCollection, $pagination);

        $criteria = new FleetCriteria($filterCollection);

        return $criteria;
    }

    /**
     * @return array
     */
    private function setDropDownList(): array
    {
        $providerCollection = $this->providerRepository->getBy(new ProviderCriteria())->getCollection()->toArray();
        $saleMethodCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection()->toArray();
        $purchaseTypeCollection = $this->purchaseTypeRepository->getBy(new PurchaseTypeCriteria())->getCollection()->toArray();
        $trimCollection = $this->trimRepository->getBy(new TrimCriteria())->getCollection()->toArray();
        $motorizationTypeCollection = $this->motorizationTypeRepository->getBy(new MotorizationTypeCriteria())->getCollection()->toArray();
        $gearBoxCollection = $this->gearBoxRepository->getBy(new GearBoxCriteria())->getCollection()->toArray();
        $colorMIRCollection = $this->colorMIRRepository->getBy(new ColorMIRCriteria())->getCollection()->toArray();
        $vehicleSeatsCollection = $this->vehicleSeatsRepository->getBy(new VehicleSeatsCriteria())->getCollection()->toArray();
        $vehicleTypeCollection = $this->vehicleTypeRepository->getBy(new VehicleTypeCriteria())->getCollection()->toArray();
        $vehicleGroupCollection = $this->vehicleGroupRepository->getBy(new CarGroupCriteria())->getCollection()->toArray();
        $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection()->toArray();
        $locationCollection = $this->locationRepository->getBy(new LocationCriteria())->getCollection()->toArray();
        $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection()->toArray();

        usort($providerCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $providerList = array_map(function ($provider) {
            /**
             * @var Provider $provider
             */
            return sprintf("%s | %s", $provider->getProviderSAPId(), $provider->getName());
        }, $providerCollection);
        $customerList = array_map(function ($customer) {
            /**
             * @var Provider $customer
             */
            return sprintf("%s | %s", $customer->getCustomerSAPId(), $customer->getName());
        }, $providerCollection);

        usort($saleMethodCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $saleMethodList = array_map(function ($saleMethod) {
            /**
             * @var SaleMethod $saleMethod
             */
            return $saleMethod->getName();
        }, $saleMethodCollection);

        usort($purchaseTypeCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $purchaseTypeList = array_map(function ($purchaseType) {
            /**
             * @var PurchaseType $purchaseType
             */
            return $purchaseType->getName();
        }, $purchaseTypeCollection);

        usort($trimCollection, function ($a, $b) {
            $brandComparison = strcmp($a->getBrand() ? $a->getBrand()->getName() : '', $b->getBrand() ? $b->getBrand()->getName() : '');
            if ($brandComparison !== 0) {
                return $brandComparison;
            }

            $modelComparison = strcmp($a->getModel() ? $a->getModel()->getName() : '', $b->getModel() ? $b->getModel()->getName() : '');
            if ($modelComparison !== 0) {
                return $modelComparison;
            }

            return strcmp($a->getName(), $b->getName());
        });
        $trimList = array_map(function ($trim) {
            /**
             * @var Trim $trim
             */
            return sprintf(
                "%s | %s %s %s",
                $trim->getId(),
                $trim->getBrand() ? $trim->getBrand()->getName() : null,
                $trim->getModel() ? $trim->getModel()->getName() : null,
                $trim->getName()
            );
        }, $trimCollection);

        usort($motorizationTypeCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $motorizationTypeList = array_map(function ($motorizationType) {
            /**
             * @var MotorizationType $motorizationType
             */
            return $motorizationType->getName();
        }, $motorizationTypeCollection);

        usort($gearBoxCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $gearBoxList = array_map(function ($gearBox) {
            /**
             * @var GearBox $gearBox
             */
            return $gearBox->getName();
        }, $gearBoxCollection);

        usort($colorMIRCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $colorMIRList = array_map(function ($colorMIR) {
            /**
             * @var ColorMIR $colorMIR
             */
            return $colorMIR->getName();
        }, $colorMIRCollection);

        usort($vehicleSeatsCollection, function ($a, $b) {
            return strcmp($a->getValue(), $b->getValue());
        });
        $vehicleSeatsList = array_map(function ($vehicleSeats) {
            /**
             * @var VehicleSeats $vehicleSeats
             */
            return $vehicleSeats->getValue();
        }, $vehicleSeatsCollection);

        usort($vehicleTypeCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $vehicleTypeList = array_map(function ($vehicleType) {
            /**
             * @var VehicleType $vehicleType
             */
            return $vehicleType->getName();
        }, $vehicleTypeCollection);

        usort($vehicleGroupCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $vehicleGroupList = array_map(function ($vehicleGroup) {
            /**
             * @var CarGroup $vehicleGroup
             */
            return $vehicleGroup->getName();
        }, $vehicleGroupCollection);

        usort($acrissCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $acrissList = array_map(function ($acriss) {
            /**
             * @var Acriss $acriss
             */
            return sprintf(
                "%s (%s)",
                $acriss->getName(),
                $acriss->getVehicleGroup() ? $acriss->getVehicleGroup()->getName() : null
            );
        }, $acrissCollection);

        usort($locationCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $locationList = array_map(function ($location) {
            /**
             * @var Location $location
             */
            return $location->getName();
        }, $locationCollection);

        usort($vehicleStatusCollection, function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });
        $vehicleStatusList = array_map(function ($vehicleStatus) {
            /**
             * @var VehicleStatus $vehicleStatus
             */
            return $vehicleStatus->getName();
        }, $vehicleStatusCollection);

        $dropdownLists = [
            FleetExcelColumns::getNameById('providerSAPId') => [
                'values' => $providerList,
                'allowBlank' => !FleetExcelColumns::getById('providerSAPId')['required'],
            ],
            FleetExcelColumns::getNameById('saleMethod') => [
                'values' => $saleMethodList,
                'allowBlank' => !FleetExcelColumns::getById('saleMethod')['required'],
            ],
            FleetExcelColumns::getNameById('purchaseType') => [
                'values' => $purchaseTypeList,
                'allowBlank' => !FleetExcelColumns::getById('purchaseType')['required'],
            ],
            FleetExcelColumns::getNameById('customerSAPId') => [
                'values' => $customerList,
                'allowBlank' => !FleetExcelColumns::getById('customerSAPId')['required'],
            ],
            FleetExcelColumns::getNameById('trimId') => [
                'values' => $trimList,
                'allowBlank' => !FleetExcelColumns::getById('trimId')['required'],
            ],
            FleetExcelColumns::getNameById('motorizationType') => [
                'values' => $motorizationTypeList,
                'allowBlank' => !FleetExcelColumns::getById('motorizationType')['required'],
            ],
            FleetExcelColumns::getNameById('gearBox') => [
                'values' => $gearBoxList,
                'allowBlank' => !FleetExcelColumns::getById('gearBox')['required'],
            ],
            FleetExcelColumns::getNameById('colorMIR') => [
                'values' => $colorMIRList,
                'allowBlank' => !FleetExcelColumns::getById('colorMIR')['required'],
            ],
            FleetExcelColumns::getNameById('vehicleSeats') => [
                'values' => $vehicleSeatsList,
                'allowBlank' => !FleetExcelColumns::getById('vehicleSeats')['required'],
            ],
            FleetExcelColumns::getNameById('vehicleType') => [
                'values' => $vehicleTypeList,
                'allowBlank' => !FleetExcelColumns::getById('vehicleType')['required'],
            ],
            FleetExcelColumns::getNameById('vehicleGroup') => [
                'values' => $vehicleGroupList,
                'allowBlank' => !FleetExcelColumns::getById('vehicleGroup')['required'],
            ],
            FleetExcelColumns::getNameById('acriss') => [
                'values' => $acrissList,
                'allowBlank' => !FleetExcelColumns::getById('acriss')['required'],
            ],
            FleetExcelColumns::getNameById('receptionLocation') => [
                'values' => $locationList,
                'allowBlank' => !FleetExcelColumns::getById('receptionLocation')['required'],
            ],
            FleetExcelColumns::getNameById('insurancePolicyProviderSAPId') => [
                'values' => $providerList,
                'allowBlank' => !FleetExcelColumns::getById('insurancePolicyProviderSAPId')['required'],
            ],
            FleetExcelColumns::getNameById('actualLocation') => [
                'values' => $locationList,
                'allowBlank' => !FleetExcelColumns::getById('actualLocation')['required'],
            ],
            FleetExcelColumns::getNameById('vehicleStatus') => [
                'values' => $vehicleStatusList,
                'allowBlank' => !FleetExcelColumns::getById('vehicleStatus')['required'],
            ],
        ];

        return $dropdownLists;
    }
}
