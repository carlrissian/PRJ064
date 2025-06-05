<?php


namespace Shared\Domain;


/**
 * Class Sanitizer
 * @package Shared\Domain
 */
class Sanitizer
{

    /**
     * Gets a number (string format) and changes its format from 1.2345,00 to 12345.00
     * symbols refer to as €, %...
     * @param string $data
     * @param array $symbols
     * @return string
     */
    public static function sanitizeNumber(string $data, array $symbols): string
    {
        $result = str_replace($symbols, '', $data);
        $result = trim($result, " \t\n\r\0\x0B ");
        if(preg_match('/,/', $result))
            $result = str_replace('.', '', $result);
        $result = str_replace(',', '.',  $result);

        return $result;
    }
}