<?php

namespace ImportSystem\Location\Domain;

class Location
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string|null
     */
    private ?string $name;

    /**
     * @var LocationType|null
     */
    private ?LocationType $locationType;

    /**
     * @var Branch|null
     */
    private ?Branch $branch;

    /**
     * @var BranchGroup|null
     */
    private ?BranchGroup $branchGroup;

    /**
     * @var Region|null
     */
    private ?Region $region;

    /**
     * @var Area|null
     */
    private ?Area $area;

    /**
     * @var Country|null
     */
    private ?Country $country;

    /**
     * @var int|null
     */
    private ?int $stockLimit;

    /**
     * @var int|null
     */
    private ?int $parkingSpots;

    /**
     * @var string|null
     */
    private ?string $email;

    /**
     * @var string|null
     */
    private ?string $phone;

    /**
     * @var string|null
     */
    private ?string $officeManager;

    /**
     * @var string|null
     */
    private ?string $address;

    /**
     * @var string|null
     */
    private ?string $gpsCoordinates;

    /**
     * @var string|null
     */
    private ?string $postalCode;

    /**
     * @var string|null
     */
    private ?string $city;

    /**
     * @var State|null
     */
    private ?State $state;

    /**
     * @var int|null
     */
    private ?int $deskCount;

    /**
     * @var int|null
     */
    private ?int $totemCount;

    /**
     * @var string|null
     */
    private ?string $parkingSituation;

    /**
     * @var bool|null
     */
    private ?bool $parkingDryCleaning;

    /**
     * @var Provider|null
     */
    private ?Provider $provider;

    /**
     * @var string|null
     */
    private ?string $frontOfficeSchedule;

    /**
     * @var string|null
     */
    private ?string $fleetReceptionSchedule;


    public function __construct(
        int $id,
        ?string $name = null,
        ?LocationType $locationType = null,
        ?Branch $branch = null,
        ?BranchGroup $branchGroup = null,
        ?Region $region = null,
        ?Area $area = null,
        ?Country $country = null,
        ?int $stockLimit = null,
        ?int $parkingSpots = null,
        ?string $email = null,
        ?string $phone = null,
        ?string $officeManager = null,
        ?string $address = null,
        ?string $gpsCoordinates = null,
        ?string $postalCode = null,
        ?string $city = null,
        ?State $state = null,
        ?int $deskCount = null,
        ?int $totemCount = null,
        ?string $parkingSituation = null,
        ?bool $parkingDryCleaning = null,
        ?Provider $provider = null,
        ?string $frontOfficeSchedule = null,
        ?string $fleetReceptionSchedule = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->locationType = $locationType;
        $this->branch = $branch;
        $this->branchGroup = $branchGroup;
        $this->region = $region;
        $this->area = $area;
        $this->country = $country;
        $this->stockLimit = $stockLimit;
        $this->parkingSpots = $parkingSpots;
        $this->email = $email;
        $this->phone = $phone;
        $this->officeManager = $officeManager;
        $this->address = $address;
        $this->gpsCoordinates = $gpsCoordinates;
        $this->postalCode = $postalCode;
        $this->state = $state;
        $this->city = $city;
        $this->deskCount = $deskCount;
        $this->totemCount = $totemCount;
        $this->parkingSituation = $parkingSituation;
        $this->parkingDryCleaning = $parkingDryCleaning;
        $this->frontOfficeSchedule = $frontOfficeSchedule;
        $this->fleetReceptionSchedule = $fleetReceptionSchedule;
        $this->provider = $provider;
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
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return LocationType|null
     */
    public function getLocationType(): ?LocationType
    {
        return $this->locationType;
    }

    /**
     * @return Branch|null
     */
    public function getBranch(): ?Branch
    {
        return $this->branch;
    }

    /**
     * @return BranchGroup|null
     */
    public function getBranchGroup(): ?BranchGroup
    {
        return $this->branchGroup;
    }

    /**
     * @param BranchGroup|null $branchGroup
     */
    public function setBranchGroup($branchGroup)
    {
        $this->branchGroup = $branchGroup;
    }

    /**
     * @return Region|null
     */
    public function getRegion(): ?Region
    {
        return $this->region;
    }

    /**
     * @return Area|null
     */
    public function getArea(): ?Area
    {
        return $this->area;
    }

    /**
     * @return Country|null
     */
    public function getCountry(): ?Country
    {
        return $this->country;
    }

    /**
     * @return int|null
     */
    public function getStockLimit(): ?int
    {
        return $this->stockLimit;
    }

    /**
     * @return int|null
     */
    public function getParkingSpots(): ?int
    {
        return $this->parkingSpots;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return string|null
     */
    public function getOfficeManager(): ?string
    {
        return $this->officeManager;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getGPSCoordinates(): ?string
    {
        return $this->gpsCoordinates;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return State|null
     */
    public function getState(): ?State
    {
        return $this->state;
    }

    /**
     * @return int|null
     */
    public function getDeskCount(): ?int
    {
        return $this->deskCount;
    }

    /**
     * @return int|null
     */
    public function getTotemCount(): ?int
    {
        return $this->totemCount;
    }

    /**
     * @return string|null
     */
    public function getParkingSituation(): ?string
    {
        return $this->parkingSituation;
    }

    /**
     * @return bool|null
     */
    public function getParkingDryCleaning(): ?bool
    {
        return $this->parkingDryCleaning;
    }

    /**
     * @return Provider|null
     */
    public function getProvider(): ?Provider
    {
        return $this->provider;
    }

    /**
     * @return string|null
     */
    public function getFrontOfficeSchedule(): ?string
    {
        return $this->frontOfficeSchedule;
    }

    /**
     * @return string|null
     */
    public function getFleetReceptionSchedule(): ?string
    {
        return $this->fleetReceptionSchedule;
    }


    /**
     * @param array|null $locationArray
     * @return self
     */
    public static function createFromArray(?array $locationArray): self
    {
        return new self(
            intval($locationArray['ID']),
            $locationArray['LOCATIONNAME'] ?? null,
            (isset($locationArray['LocationType'])) ? LocationType::createFromArray($locationArray['LocationType']) : null,
            (isset($locationArray['Branch'])) ? Branch::createFromArray($locationArray['Branch']) : null,
            // FIXME descomentar una vez WS lo devuelva
            // (isset($locationArray['BranchGroup'])) ? BranchGroup::createFromArray($locationArray['BranchGroup']) : null,
            null,
            (isset($locationArray['Region'])) ? Region::createFromArray($locationArray['Region']) : null,
            (isset($locationArray['Area'])) ? Area::createFromArray($locationArray['Area']) : null,
            (isset($locationArray['Countries'])) ? Country::createFromArray($locationArray['Countries']) : null,
            (isset($locationArray['LOCATIONSTOCKLIMIT']) && is_numeric($locationArray['LOCATIONSTOCKLIMIT'])) ? intval($locationArray['LOCATIONSTOCKLIMIT']) : null,
            (isset($locationArray['LOCATIONPARKINGSPOTS']) && is_numeric($locationArray['LOCATIONPARKINGSPOTS'])) ? intval($locationArray['LOCATIONPARKINGSPOTS']) : null,
            $locationArray['LOCATIONEMAIL'] ?? null,
            $locationArray['LOCATIONPHONE'] ?? null,
            $locationArray['LOCATIONOFFICEMNG'] ?? null,
            $locationArray['LOCATIONADD'] ?? null,
            $locationArray['LOCATIONGPS'] ?? null,
            $locationArray['LOCATIONPC'] ?? null,
            $locationArray['LOCATIONCITY'] ?? null,
            (isset($locationArray['State'])) ? State::createFromArray($locationArray['State']) : null,
            (isset($locationArray['LOCATIONDESKCOUNT']) && is_numeric($locationArray['LOCATIONDESKCOUNT'])) ? intval($locationArray['LOCATIONDESKCOUNT']) : null,
            (isset($locationArray['LOCATIONTOTEMCOUNT']) && is_numeric($locationArray['LOCATIONTOTEMCOUNT'])) ? intval($locationArray['LOCATIONTOTEMCOUNT']) : null,
            $locationArray['PARKINGSITUATION'] ?? null,
            (isset($locationArray['PARKINGDRYCLEANING']) && is_numeric($locationArray['PARKINGDRYCLEANING'])) ? boolval($locationArray['PARKINGDRYCLEANING']) : null,
            (isset($locationArray['Provider'])) ? Provider::createFromArray($locationArray['Provider']) : null,
            $locationArray['FRONTOFFICESCHEDULEID'] ?? null,
            $locationArray['FLEETRECEPTIONSCHEDULEID'] ?? null
        );
    }

    /**
     * @return array
     */
    final public function toArray(): array
    {
        return [
            'ID' => $this->getId(),
            "LOCATIONNAME" => $this->getName(),
            "LOCATIONTYPE" => ($this->getLocationType()) ? $this->getLocationType()->toArray() : null,
            "BRANCH" => ($this->getBranch()) ? $this->getBranch()->toArray() : null,
            "AREA" => ($this->getArea()) ? $this->getArea()->toArray() : null,
            "COUNTRY" => ($this->getCountry()) ? $this->getCountry()->toArray() : null,
            "LOCATIONSTOCKLIMIT" => $this->getStockLimit(),
            "LOCATIONPARKINGSPOTS" => $this->getParkingSpots(),
            "LOCATIONEMAIL" => $this->getEmail(),
            "LOCATIONPHONE" => $this->getPhone(),
            "LOCATIONOFFICEMNG" => $this->getOfficeManager(),
            "LOCATIONADD" => $this->getAddress(),
            "LOCATIONGPS" => $this->getGPSCoordinates(),
            "PROVIDER" => ($this->getProvider()) ? $this->getProvider()->toArray() : null,
            "PROVINCE" => ($this->getState()) ? $this->getState()->toArray() : null,
            "LOCATIONCITY" => $this->getCity(),
            "LOCATIONDESKCOUNT" => $this->getDeskCount(),
            "LOCATIONTOTEMCOUNT" => $this->getTotemCount(),
            "PARKINGSITUATION" => $this->getParkingSituation(),
            "PARKINGDRYCLEANING" => $this->getParkingDryCleaning() ? 1 : 0,
            "LOCATIONPC" => $this->getPostalCode(),
            "FRONTOFFICESCHEDULEID" => $this->getFrontOfficeSchedule(),
            "FLEETRECEPTIONSCHEDULEID" => $this->getFleetReceptionSchedule(),
        ];
    }
}
