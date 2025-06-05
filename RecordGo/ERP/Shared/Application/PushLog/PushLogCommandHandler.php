<?php

namespace Shared\Application\PushLog;


use Shared\Domain\Logs\LogHelper;

class PushLogCommandHandler
{

    /**
     * @var LogHelper
     */
    private LogHelper $logHelper;

    public function __construct(LogHelper $logHelper)
    {
        $this->logHelper = $logHelper;
    }

    public function handle(PushLogCommand $command)
    {
        $this->logHelper->log(
            $command->getMethod(),
            $command->getStatusCode(),
            $command->getIp(),
            $command->getMessage(),
            $command->getType()
        );
    }

}