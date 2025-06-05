<?php

namespace Shared\Domain\RequestHelper;

interface RequestHelperInterface
{
    function request($method, $functionName, $body);

}