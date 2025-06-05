<?php

namespace ImportSystem\Fleet\Domain;

use ImportSystem\Fleet\Infrastructure\SAP\DTO\FleetImportResponse;

/**
 * Interface FleetRepository
 * @package ImportSystem\Fleet\Domain
 */
interface FleetRepository
{
    /**
     * @param array $fleetImportData
     * @return FleetImportResponse
     */
    public function import(array $fleetImportData): FleetImportResponse;

    /**
     * @param FleetCriteria $criteria
     * @return FleetCollection
     */
    public function export(FleetCriteria $criteria): FleetCollection;
}
