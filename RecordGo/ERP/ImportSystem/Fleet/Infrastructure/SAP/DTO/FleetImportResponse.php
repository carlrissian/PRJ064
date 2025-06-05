<?php

namespace ImportSystem\Fleet\Infrastructure\SAP\DTO;

use Shared\Domain\OperationResponse;

final class FleetImportResponse
{

    private OperationResponse $operationResponse;
    private array $errors;

    /**
     * @param OperationResponse $operationResponse
     * @param array $errors
     */
    public function __construct(OperationResponse $operationResponse, array $errors)
    {
        $this->operationResponse = $operationResponse;
        $this->errors = $errors;
    }

    public function getOperationResponse(): OperationResponse
    {
        return $this->operationResponse;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public static function fromArray(array $data): FleetImportResponse
    {
        return new FleetImportResponse(
            OperationResponse::createFromArray($data['TOperationResponse']),
            $data['TVehicleErrorResponses']
        );
    }

}