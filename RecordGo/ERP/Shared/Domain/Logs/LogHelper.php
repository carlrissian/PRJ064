<?php

namespace Shared\Domain\Logs;

interface LogHelper
{
    public function log(string $method, int $status, string $ip, string $message, string $type): void;

}