<?php


namespace Shared\Application\PushLog;


class PushLogCommand
{
    /**
     * @var string
     */
    private $message;
   /**
    * @var string|null
    */
    private $method;
    /**
     * @var int|null
     */
    private $statusCode;
    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var string|null
     */
    private $type;

    /**
     * StoreLogCommand constructor.
     * @param string $message
     * @param string|null $method
     * @param int|null $statusCode
     * @param string|null $ip
     * @param string|null $type
     */
    public function __construct(string $message, ?string $method ='GET', ?int $statusCode = 200, ?string $ip = '', ?string $type = 'INFO')
    {
        $this->message = $message;
        $this->method = $method;
        $this->statusCode = $statusCode;
        $this->ip = $ip;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }


    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}