<?php

namespace ImportSystem\Vehicle\Application\VehicleUpdate;

use ImportSystem\Vehicle\Domain\VehicleStatus;

class VehicleUpdateCommand
{

    /**
     * @var array $command
     */

    private $command;

    /**
     * @param array $command
     */
    public function __construct(array $command)
    {
        $this->command = $command;
    }

    /**
     * @return array
     */
    public function getCommand(): array
    {
        return $this->command;
    }


}