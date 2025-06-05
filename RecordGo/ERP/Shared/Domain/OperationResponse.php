<?php

namespace Shared\Domain;

final class OperationResponse
{
    /**
     * @var bool
     */
    private $success;

    /**
     * @var int|null
     */
    private $code;

    /**
     * @var string|null
     */
    private $message;

    /**
     * OperationResponse constructor.
     *
     * @param boolean $success
     * @param integer|null $code
     * @param string|null $message
     */
    public function __construct(
        bool $success,
        ?int $code = null,
        ?string $message = null
    ) {
        $this->success = $success;
        $this->code = $code;
        $this->message = $message;
    }

    /**
     * @param array $operationResponseArray
     * @return self
     */
    public static function createFromArray(array $operationResponseArray): self
    {
        return new self(
            filter_var($operationResponseArray['SUCCESS'], FILTER_VALIDATE_BOOLEAN),
            is_numeric($operationResponseArray['CODE']) ? intval($operationResponseArray['CODE']) : null,
            $operationResponseArray['MESSAGE'] ?? null
        );
    }

    /**
     * @return bool
     */
    public function wasSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }
}
