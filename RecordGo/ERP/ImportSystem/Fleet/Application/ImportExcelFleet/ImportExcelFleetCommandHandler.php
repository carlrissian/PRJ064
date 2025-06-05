<?php

namespace ImportSystem\Fleet\Application\ImportExcelFleet;

use DateTime;
use ImportSystem\Trim\Domain\TrimCriteria;
use ImportSystem\Trim\Domain\TrimRepository;
use ImportSystem\Fleet\Domain\FileRepository;
use ImportSystem\Acriss\Domain\AcrissCriteria;
use ImportSystem\Fleet\Domain\FleetRepository;
use Symfony\Component\HttpFoundation\Response;
use ImportSystem\Acriss\Domain\AcrissRepository;
use ImportSystem\Fleet\Domain\FleetExcelColumns;
use ImportSystem\GearBox\Domain\GearBoxCriteria;
use ImportSystem\CarGroup\Domain\CarGroupCriteria;
use ImportSystem\ColorMIR\Domain\ColorMIRCriteria;
use ImportSystem\GearBox\Domain\GearBoxRepository;
use ImportSystem\Location\Domain\LocationCriteria;
use ImportSystem\Provider\Domain\ProviderCriteria;
use ImportSystem\CarGroup\Domain\CarGroupRepository;
use ImportSystem\ColorMIR\Domain\ColorMIRRepository;
use ImportSystem\Location\Domain\LocationRepository;
use ImportSystem\Provider\Domain\ProviderRepository;
use ImportSystem\SaleMethod\Domain\SaleMethodCriteria;
use Shared\Constants\Infrastructure\ConstantsJsonFile;
use ImportSystem\Fleet\Domain\ImportFleetExcelException;
use ImportSystem\SaleMethod\Domain\SaleMethodRepository;
use ImportSystem\VehicleType\Domain\VehicleTypeCriteria;
use ImportSystem\PurchaseType\Domain\PurchaseTypeCriteria;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsCriteria;
use ImportSystem\VehicleType\Domain\VehicleTypeRepository;
use ImportSystem\PurchaseType\Domain\PurchaseTypeRepository;
use ImportSystem\VehicleSeats\Domain\VehicleSeatsRepository;
use ImportSystem\VehicleStatus\Domain\VehicleStatusCriteria;
use ImportSystem\VehicleStatus\Domain\VehicleStatusRepository;
use ImportSystem\MotorizationType\Domain\MotorizationTypeCriteria;
use ImportSystem\MotorizationType\Domain\MotorizationTypeRepository;

class ImportExcelFleetCommandHandler
{
    private const NIVE_LENGTH = 32;

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
     * @var array
     */
    private array $excelHeaders;

    /**
     * @var array
     */
    private array $excelBody;

    /**
     * @var array
     */
    private array $excelErrors;

    /**
     * @var array|null
     */
    private ?array $managedVehicles;

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

        $this->excelHeaders = [];
        $this->excelBody = [];
        $this->excelErrors = [];
        $this->managedVehicles = [
            "imported" => [],
            "notImported" => [],
        ];
    }

    /**
     * @param ImportExcelFleetCommand $command
     * @return ImportExcelFleetResponse
     */
    public function handle(ImportExcelFleetCommand $command): ImportExcelFleetResponse
    {
        [$this->excelHeaders, $excelBody] = $this->fileRepository->import($command->getFile());

        $this->checkHeaders();

        if (!empty($this->excelErrors)) {
            throw new ImportFleetExcelException('errorImportFleetNotification', $this->excelErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->checkBody($excelBody);

        if (!empty($this->excelErrors)) {
            throw new ImportFleetExcelException('errorImportFleetNotification', $this->excelErrors, Response::HTTP_BAD_REQUEST);
        }

        $this->verifyData();

        $vehiclesToImport = array_filter($this->excelBody, function ($row) {
            return !in_array($row['line'], array_keys($this->managedVehicles['notImported']));
        });

        if (count($vehiclesToImport) === 0) {
            throw new ImportFleetExcelException('errorImportFleetNotification', $this->managedVehicles, Response::HTTP_BAD_REQUEST);
        }

        $response = $this->fleetRepository->import($vehiclesToImport);

        $this->checkResponse($response, $vehiclesToImport);

        return new ImportExcelFleetResponse($response->getOperationResponse()->wasSuccess(), 'importFleetSuccessNotification', $this->managedVehicles, $response->getErrors() ?? null);
    }

    /**
     * @return void
     */
    private function checkHeaders(): void
    {
        if (empty($this->excelHeaders)) {
            $this->excelErrors[] = 'The excel file cannot be empty.';
        }

        foreach ($this->excelHeaders as $header) {
            if (!FleetExcelColumns::nameExists($header)) {
                $suggestionCol = FleetExcelColumns::nameLike($header);
                $this->excelErrors[] = $suggestionCol !== null ? "Column '$header' not found. Maybe you meant '{$suggestionCol['name']}'?" : "Column '$header' not found.";
            }
        }
    }

    /**
     * @param array $headers
     * @return void
     */
    private function checkBody(array $body): void
    {
        if (empty($body)) {
            $this->excelErrors[] = 'No data has been entered.';
        }

        try {
            // Carga de listados de dropdowns
            $providerCollection = $this->providerRepository->getBy(new ProviderCriteria())->getCollection();
            $saleMethodCollection = $this->saleMethodRepository->getBy(new SaleMethodCriteria())->getCollection();
            $purchaseTypeCollection = $this->purchaseTypeRepository->getBy(new PurchaseTypeCriteria())->getCollection();
            $trimCollection = $this->trimRepository->getBy(new TrimCriteria())->getCollection();
            $motorizationTypeCollection = $this->motorizationTypeRepository->getBy(new MotorizationTypeCriteria())->getCollection();
            $gearBoxCollection = $this->gearBoxRepository->getBy(new GearBoxCriteria())->getCollection();
            $colorMIRCollection = $this->colorMIRRepository->getBy(new ColorMIRCriteria())->getCollection();
            $vehicleSeatsCollection = $this->vehicleSeatsRepository->getBy(new VehicleSeatsCriteria())->getCollection();
            $vehicleTypeCollection = $this->vehicleTypeRepository->getBy(new VehicleTypeCriteria())->getCollection();
            $vehicleGroupCollection = $this->vehicleGroupRepository->getBy(new CarGroupCriteria())->getCollection();
            $acrissCollection = $this->acrissRepository->getBy(new AcrissCriteria())->getCollection();
            $locationCollection = $this->locationRepository->getBy(new LocationCriteria())->getCollection();
            $vehicleStatusCollection = $this->vehicleStatusRepository->getBy(new VehicleStatusCriteria())->getCollection();


            $dropdownCollections = [
                "providerSAPId" => $providerCollection,
                "saleMethod" => $saleMethodCollection,
                "purchaseType" => $purchaseTypeCollection,
                "customerSAPId" => $providerCollection,
                "trimId" => $trimCollection,
                "motorizationType" => $motorizationTypeCollection,
                "gearBox" => $gearBoxCollection,
                "colorMIR" => $colorMIRCollection,
                "vehicleSeats" => $vehicleSeatsCollection,
                "vehicleType" => $vehicleTypeCollection,
                "vehicleGroup" => $vehicleGroupCollection,
                "acriss" => $acrissCollection,
                "receptionLocation" => $locationCollection,
                "insurancePolicyProviderSAPId" => $providerCollection,
                "actualLocation" => $locationCollection,
                "vehicleStatus" => $vehicleStatusCollection,
            ];
        } catch (\Throwable $th) {
            $this->excelErrors[] = 'Error loading dropdowns data.';
        }


        foreach ($body as $bodyRow) {
            $formattedElement = [];
            foreach ($bodyRow as $column => $element) {
                if ($column !== "line") {
                    $columnData = FleetExcelColumns::getByName($column);

                    if (isset($columnData['default']) && empty($element)) {
                        $element = str_contains($columnData['default'], "_") ? ConstantsJsonFile::getValue($columnData['default']) : $columnData['default'];
                    }

                    if ($columnData['required'] && empty($element)) {
                        $this->managedVehicles['notImported'][$bodyRow['line']][] = "Column '$column' is required.";
                    }

                    if ($columnData['dropdown'] && !empty($element) && !isset($columnData['default'])) {
                        if (str_contains($element, "|")) {
                            $element = trim(explode("|", $element)[0]);
                        } else if (str_contains($element, "(")) {
                            $element = trim(explode("(", $element)[0]);
                        }

                        if (isset($dropdownCollections[$columnData['id']])) {
                            try {
                                $dropdown = $dropdownCollections[$columnData['id']];
                                $foundItem = $dropdown->getByProperty($element, $columnData['findBy']);
                                $element = $foundItem->getId();
                            } catch (\Throwable $th) {
                                $this->managedVehicles['notImported'][$bodyRow['line']][] = "Didn't find dropdown option '$element', from column '$column'.";
                            }
                        } else {
                            $this->managedVehicles['notImported'][$bodyRow['line']][] = "Didn't find dropdown options for column '$column'.";
                        }
                    }


                    switch ($columnData['dataType']) {
                        case 'string':
                            $element = strval($element);
                            break;
                        case 'int':
                            if ($columnData['required'] && !empty($element) && !is_numeric($element)) {
                                $this->managedVehicles['notImported'][$bodyRow['line']][] = "Data type is not numeric for column '$column'.";
                            }
                            break;
                        case 'float':
                            if ($columnData['required'] && !empty($element) && !is_numeric($element) && !is_float(floatval($element))) {
                                $this->managedVehicles['notImported'][$bodyRow['line']][] = "Data type is not decimal for column '$column'.";
                            }
                            break;
                        case 'date':
                            if (!empty($element)) {
                                try {
                                    $dateFormat = 'd/m/Y';
                                    $date = is_numeric($element) ? date($dateFormat, $element) : $element;
                                    $dateTime = DateTime::createFromFormat($dateFormat, $date);
                                    $element = $dateTime->getTimestamp();
                                } catch (\Throwable $th) {
                                    $this->managedVehicles['notImported'][$bodyRow['line']][] = "Data type is not date for column '$column'.";
                                }
                            }
                            break;
                        default:
                            $this->managedVehicles['notImported'][$bodyRow['line']][] = "Data type not found for column '$column'.";
                            break;
                    }

                    $formattedElement['line'] = $bodyRow['line'];
                    $formattedElement[$columnData['id']] = $element;
                }
            }
            $this->excelBody[] = $formattedElement;
        }
    }

    /**
     * @return void
     */
    private function verifyData(): void
    {
        foreach ($this->excelBody as $element) {
            
            // Determinar si el vehículo ya existe por NIVE
            $vehicle = $this->fleetRepository->findByNive($element['nive']);
            $isNew = $vehicle === null;

            // Campos protegidos por tipo de importación
            if ($isNew) {
                // VEHÍCULO NUEVO
                $element['currentLocation'] = $element['receptionLocation'] ?? $element['currentLocation'];
                $element['vehicleStatus'] = 'New vin';
                $element['currentKm'] = $element['initialKm'] ?? $element['currentKm'];
            } else {
                // VEHÍCULO EXISTENTE
                unset($element['currentLocation']);
                unset($element['vehicleStatus']);
                unset($element['currentKm']);
            }

            if ($element['returnDate'] && $element['rentingEndDate'] > $element['returnDate']) {
                $this->managedVehicles['notImported'][$element['line']][] = "Renting end date can't be greater than return date.";
            }
            if ($element['nive'] && strlen($element['nive']) > 0 && strlen($element['nive']) !== self::NIVE_LENGTH) {
                $this->managedVehicles['notImported'][$element['line']][] = sprintf("NIVE must have %d characters.", self::NIVE_LENGTH);
            }
        }
    }

    private function checkResponse(object $response, array $vehiclesToImport): void
    {
        if (count($response->getErrors()) > 0) {
            foreach ($vehiclesToImport as $vehicle) {
                $imported = false;

                foreach ($response->getErrors() as $error) {
                    $imported = !str_contains($error, strval($vehicle['line'] - 1));
                    if ($imported) {
                        $this->managedVehicles['imported'] = $vehicle;
                        break;
                    }
                }
            }
        } else {
            $this->managedVehicles['imported'] = array_filter($this->excelBody, function ($row) {
                return !in_array($row['line'], array_keys($this->managedVehicles['notImported']));
            });
        }
    }
}
