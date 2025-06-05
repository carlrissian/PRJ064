<?php


namespace Shared\Utils;


/**
 * Interface PrintInterface
 * @package Shared\Utils
 */
interface PrintInterface
{
    /**
     * @param $data
     * @return string
     */
    public function print($data): string;
}