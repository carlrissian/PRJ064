<?php

namespace ImportSystem\Fleet\Application\ImportExcelFleet;

class ImportExcelFleetResponse
{
    /**
     * @var boolean
     */
    private bool $success;

    /**
     * @var string
     */
    private $message;

    /**
     * @var array
     */
    private $vehicles;

    /**
     * @var array|null
     */
    private $sapErrors;

    /**
     * @param bool $success
     * @param string $message
     * @param array $vehicles
     */
    public function __construct(
        bool $success,
        string $message,
        array $vehicles,
        ?array $sapErrors = null
    ) {
        $this->success = $success;
        $this->message = $message;
        $this->vehicles = $vehicles;
        $this->sapErrors = $sapErrors;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function getVehicles(): array
    {
        return $this->vehicles;
    }

    /**
     * @return array|null
     */
    public function getSapErrors(): ?array
    {
        return $this->sapErrors;
    }
}
