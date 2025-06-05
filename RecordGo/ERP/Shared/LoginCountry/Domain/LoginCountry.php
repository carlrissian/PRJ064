<?php

declare(strict_types=1);

namespace Shared\LoginCountry\Domain;

class LoginCountry
{
    /**
     * @var string
     */
    private string $iso;

    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $timezone;
    /**
     * @var string
     */
    private string $internalcode;

    /**
     * @param string $iso
     * @param string $name
     * @param string $timezone
     * @param string $internalcode
     */
    public function __construct(string $iso, string $name, $timezone, string $internalcode)
    {
        $this->iso = $iso;
        $this->name = $name;
        $this->timezone = $timezone;
        $this->internalcode = $internalcode;
    }

    /**
     * Get the value of iso
     *
     * @return string
     */
    public function getIso(): string
    {
        return $this->iso;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTimezone(): string
    {
        return $this->timezone;
    }

    /**
     * @return string
     */
    public function getInternalCode(): string
    {
        return $this->internalcode;
    }

}
