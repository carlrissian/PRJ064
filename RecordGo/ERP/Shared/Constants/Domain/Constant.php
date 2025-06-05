<?php

declare(strict_types=1);

namespace Shared\Constants\Domain;

class Constant
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var string
     */
    private string $value;

    /**
     * Constant constructor.
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value = '')
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function defineConstant(string $key, string $value): void
    {
        define($key, $value);
    }
}
