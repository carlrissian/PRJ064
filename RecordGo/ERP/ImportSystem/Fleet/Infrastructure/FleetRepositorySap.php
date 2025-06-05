<?php

namespace ImportSystem\Fleet\Infrastructure;

use Shared\Utils\Utils;
use ImportSystem\Fleet\Domain\Fleet;
use ImportSystem\Fleet\Domain\FleetCriteria;
use ImportSystem\Fleet\Domain\FleetCollection;
use ImportSystem\Fleet\Domain\FleetRepository;
use Shared\Domain\RequestHelper\SapRequestHelper;
use ImportSystem\Fleet\Infrastructure\SAP\DTO\FleetImportRequest;
use ImportSystem\Fleet\Infrastructure\SAP\DTO\FleetImportResponse;

class FleetRepositorySap implements FleetRepository
{
    private const PREFIX_FUNCTION_NAME = 'Vehicle/VehicleRepository';

    /**
     * @var SapRequestHelper $sapRequestHelper
     */
    public SapRequestHelper $sapRequestHelper;

    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    public function findByNive(string $nive): ?Fleet
    {
        $criteria = new FleetCriteria();
        $criteria->setNive($nive);

        $collection = $this->export($criteria);
        foreach ($collection as $fleet) {
            return $fleet;
        }

        return null;
    }


    /**
     * @inheritDoc
     */
    public function import(array $fleetImportData): FleetImportResponse
    {
        $functionName = sprintf('%s_UploadFlota_import', self::PREFIX_FUNCTION_NAME);

        try {
            $fleetImportRequestArray = [];
            foreach ($fleetImportData as $fleetImportRequest) {
                $fleetImportRequestArray[] = FleetImportRequest::mapper($fleetImportRequest);
            }
            $body = json_encode($fleetImportRequestArray);

            $response = $this->sapRequestHelper->request('POST', $functionName, $body);
            $responseArray = json_decode($response, true);

            return FleetImportResponse::fromArray($responseArray);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }

    /**
     * @inheritDoc
     */
    public function export(FleetCriteria $criteria): FleetCollection
    {
        $functionName = sprintf('%s_ExportFlota_getBy', self::PREFIX_FUNCTION_NAME);
        $collection = new FleetCollection([]);

        try {
            $body = json_encode(Utils::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);
            $responseArray = json_decode($response, true);

            if (!isset($responseArray['TVehicleResponse'])
                || !is_array($responseArray['TVehicleResponse'])) {
                // Si no viene la clave o no es un array, devolvemos colección vacía
                return $collection;
            }

            foreach ($responseArray['TVehicleResponse'] as $itemArray) {
                try {
                    $collection->add(Fleet::createFromArraySAP($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }

            return $collection;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }
    }
}
