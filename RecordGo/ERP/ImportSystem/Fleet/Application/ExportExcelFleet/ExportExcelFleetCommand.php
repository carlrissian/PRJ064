<?php

namespace ImportSystem\Fleet\Application\ExportExcelFleet;

class ExportExcelFleetCommand
{
    /**
     * @var array|null
     */
    private $providerIdIn;

    /**
     * @var array|null
     */
    private $bbCustomerIdIn;

    /**
     * @var array|null
     */
    private $purchaseTypeIdIn;

    /**
     * @var array|null
     */
    private $saleMethodIdIn;

    /**
     * @var array|null
     */
    private $brandIdIn;

    /**
     * @var array|null
     */
    private $modelIdIn;

    /**
     * @var array|null
     */
    private $trimIdIn;

    /**
     * @var array|null
     */
    private $carGroupIdIn;

    /**
     * @var array|null
     */
    private $vehicleTypeIdIn;

    /**
     * @var array|null
     */
    private $acrissIdIn;

    /**
     * @var array|null
     */
    private $gearBoxIdIn;

    /**
     * @var array|null
     */
    private $motorizationTypeIdIn;

    /**
     * @var array|null
     */
    private $receptionLocationIdIn;

    /**
     * @var array|null
     */
    private $vehicleStatusIdIn;

    /**
     * @var array|null
     */
    private $actualLocationIdIn;

    /**
     * @var string|null
     */
    private $firstRegistrationDateFrom;

    /**
     * @var string|null
     */
    private $firstRegistrationDateTo;

    /**
     * @var string|null
     */
    private $lastRegistrationDateFrom;

    /**
     * @var string|null
     */
    private $lastRegistrationDateTo;

    /**
     * @var string|null
     */
    private $deliveryDateFrom;

    /**
     * @var string|null
     */
    private $deliveryDateTo;

    /**
     * @var string|null
     */
    private $returnDateFrom;

    /**
     * @var string|null
     */
    private $returnDateTo;

    /**
     * @var string|null
     */
    private $firstRentDateFrom;

    /**
     * @var string|null
     */
    private $firstRentDateTo;

    /**
     * @var string|null
     */
    private $rentingEndDateFrom;

    /**
     * @var string|null
     */
    private $rentingEndDateTo;

    /**
     * @var string|null
     */
    private $creationDateFrom;

    /**
     * @var string|null
     */
    private $creationDateTo;

    /**
     * @var bool|null
     */
    private $onlyOperative;

    /**
     * @var bool|null
     */
    private $withoutLicensePlate;

    /**
     * ExportExcelFleetCommand constructor.
     *
     * @param array|null $providerIdIn
     * @param array|null $bbCustomerIdIn
     * @param array|null $purchaseTypeIdIn
     * @param array|null $saleMethodIdIn
     * @param array|null $brandIdIn
     * @param array|null $modelIdIn
     * @param array|null $trimIdIn
     * @param array|null $carGroupIdIn
     * @param array|null $vehicleTypeIdIn
     * @param array|null $acrissIdIn
     * @param array|null $gearBoxIdIn
     * @param array|null $motorizationTypeIdIn
     * @param array|null $receptionLocationIdIn
     * @param array|null $vehicleStatusIdIn
     * @param array|null $actualLocationIdIn
     * @param string|null $firstRegistrationDateFrom
     * @param string|null $firstRegistrationDateTo
     * @param string|null $lastRegistrationDateFrom
     * @param string|null $lastRegistrationDateTo
     * @param string|null $deliveryDateFrom
     * @param string|null $deliveryDateTo
     * @param string|null $returnDateFrom
     * @param string|null $returnDateTo
     * @param string|null $firstRentDateFrom
     * @param string|null $firstRentDateTo
     * @param string|null $rentingEndDateFrom
     * @param string|null $rentingEndDateTo
     * @param string|null $creationDateFrom
     * @param string|null $creationDateTo
     * @param boolean|null $onlyOperative
     * @param boolean|null $withoutLicensePlate
     */
    public function __construct(
        ?array $providerIdIn,
        ?array $bbCustomerIdIn,
        ?array $purchaseTypeIdIn,
        ?array $saleMethodIdIn,
        ?array $brandIdIn,
        ?array $modelIdIn,
        ?array $trimIdIn,
        ?array $carGroupIdIn,
        ?array $vehicleTypeIdIn,
        ?array $acrissIdIn,
        ?array $gearBoxIdIn,
        ?array $motorizationTypeIdIn,
        ?array $receptionLocationIdIn,
        ?array $vehicleStatusIdIn,
        ?array $actualLocationIdIn,
        ?string $firstRegistrationDateFrom,
        ?string $firstRegistrationDateTo,
        ?string $lastRegistrationDateFrom,
        ?string $lastRegistrationDateTo,
        ?string $deliveryDateFrom,
        ?string $deliveryDateTo,
        ?string $returnDateFrom,
        ?string $returnDateTo,
        ?string $firstRentDateFrom,
        ?string $firstRentDateTo,
        ?string $rentingEndDateFrom,
        ?string $rentingEndDateTo,
        ?string $creationDateFrom,
        ?string $creationDateTo,
        ?bool $onlyOperative,
        ?bool $withoutLicensePlate
    ) {
        $this->providerIdIn = $providerIdIn;
        $this->bbCustomerIdIn = $bbCustomerIdIn;
        $this->purchaseTypeIdIn = $purchaseTypeIdIn;
        $this->saleMethodIdIn = $saleMethodIdIn;
        $this->brandIdIn = $brandIdIn;
        $this->modelIdIn = $modelIdIn;
        $this->trimIdIn = $trimIdIn;
        $this->carGroupIdIn = $carGroupIdIn;
        $this->vehicleTypeIdIn = $vehicleTypeIdIn;
        $this->acrissIdIn = $acrissIdIn;
        $this->gearBoxIdIn = $gearBoxIdIn;
        $this->motorizationTypeIdIn = $motorizationTypeIdIn;
        $this->receptionLocationIdIn = $receptionLocationIdIn;
        $this->vehicleStatusIdIn = $vehicleStatusIdIn;
        $this->actualLocationIdIn = $actualLocationIdIn;
        $this->firstRegistrationDateFrom = $firstRegistrationDateFrom;
        $this->firstRegistrationDateTo = $firstRegistrationDateTo;
        $this->lastRegistrationDateFrom = $lastRegistrationDateFrom;
        $this->lastRegistrationDateTo = $lastRegistrationDateTo;
        $this->deliveryDateFrom = $deliveryDateFrom;
        $this->deliveryDateTo = $deliveryDateTo;
        $this->returnDateFrom = $returnDateFrom;
        $this->returnDateTo = $returnDateTo;
        $this->firstRentDateFrom = $firstRentDateFrom;
        $this->firstRentDateTo = $firstRentDateTo;
        $this->rentingEndDateFrom = $rentingEndDateFrom;
        $this->rentingEndDateTo = $rentingEndDateTo;
        $this->creationDateFrom = $creationDateFrom;
        $this->creationDateTo = $creationDateTo;
        $this->onlyOperative = $onlyOperative;
        $this->withoutLicensePlate = $withoutLicensePlate;
    }

    /**
     * @return array|null
     */
    public function getProviderIdIn(): ?array
    {
        return $this->providerIdIn;
    }

    /**
     * @return array|null
     */
    public function getBbCustomerIdIn(): ?array
    {
        return $this->bbCustomerIdIn;
    }

    /**
     * @return array|null
     */
    public function getPurchaseTypeIdIn(): ?array
    {
        return $this->purchaseTypeIdIn;
    }

    /**
     * @return array|null
     */
    public function getSaleMethodIdIn(): ?array
    {
        return $this->saleMethodIdIn;
    }

    /**
     * @return array|null
     */
    public function getBrandIdIn(): ?array
    {
        return $this->brandIdIn;
    }

    /**
     * @return array|null
     */
    public function getModelIdIn(): ?array
    {
        return $this->modelIdIn;
    }

    /**
     * @return array|null
     */
    public function getTrimIdIn(): ?array
    {
        return $this->trimIdIn;
    }

    /**
     * @return array|null
     */
    public function getCarGroupIdIn(): ?array
    {
        return $this->carGroupIdIn;
    }

    /**
     * @return array|null
     */
    public function getVehicleTypeIdIn(): ?array
    {
        return $this->vehicleTypeIdIn;
    }

    /**
     * @return array|null
     */
    public function getAcrissIdIn(): ?array
    {
        return $this->acrissIdIn;
    }

    /**
     * @return array|null
     */
    public function getGearBoxIdIn(): ?array
    {
        return $this->gearBoxIdIn;
    }

    /**
     * @return array|null
     */
    public function getMotorizationTypeIdIn(): ?array
    {
        return $this->motorizationTypeIdIn;
    }

    /**
     * @return array|null
     */
    public function getReceptionLocationIdIn(): ?array
    {
        return $this->receptionLocationIdIn;
    }

    /**
     * @return array|null
     */
    public function getVehicleStatusIdIn(): ?array
    {
        return $this->vehicleStatusIdIn;
    }

    /**
     * @return array|null
     */
    public function getActualLocationIdIn(): ?array
    {
        return $this->actualLocationIdIn;
    }

    /**
     * @return string|null
     */
    public function getFirstRegistrationDateFrom(): ?string
    {
        return $this->firstRegistrationDateFrom;
    }

    /**
     * @return string|null
     */
    public function getFirstRegistrationDateTo(): ?string
    {
        return $this->firstRegistrationDateTo;
    }

    /**
     * @return string|null
     */
    public function getLastRegistrationDateFrom(): ?string
    {
        return $this->lastRegistrationDateFrom;
    }

    /**
     * @return string|null
     */
    public function getLastRegistrationDateTo(): ?string
    {
        return $this->lastRegistrationDateTo;
    }

    /**
     * @return string|null
     */
    public function getDeliveryDateFrom(): ?string
    {
        return $this->deliveryDateFrom;
    }

    /**
     * @return string|null
     */
    public function getDeliveryDateTo(): ?string
    {
        return $this->deliveryDateTo;
    }

    /**
     * @return string|null
     */
    public function getReturnDateFrom(): ?string
    {
        return $this->returnDateFrom;
    }

    /**
     * @return string|null
     */
    public function getReturnDateTo(): ?string
    {
        return $this->returnDateTo;
    }

    /**
     * @return string|null
     */
    public function getFirstRentDateFrom(): ?string
    {
        return $this->firstRentDateFrom;
    }

    /**
     * @return string|null
     */
    public function getFirstRentDateTo(): ?string
    {
        return $this->firstRentDateTo;
    }

    /**
     * @return string|null
     */
    public function getRentingEndDateFrom(): ?string
    {
        return $this->rentingEndDateFrom;
    }

    /**
     * @return string|null
     */
    public function getRentingEndDateTo(): ?string
    {
        return $this->rentingEndDateTo;
    }

    /**
     * @return string|null
     */
    public function getCreationDateFrom(): ?string
    {
        return $this->creationDateFrom;
    }

    /**
     * @return string|null
     */
    public function getCreationDateTo(): ?string
    {
        return $this->creationDateTo;
    }

    /**
     * @return bool|null
     */
    public function isOnlyOperative(): ?bool
    {
        return $this->onlyOperative;
    }

    /**
     * @return bool|null
     */
    public function isWithoutLicensePlate(): ?bool
    {
        return $this->withoutLicensePlate;
    }
}
