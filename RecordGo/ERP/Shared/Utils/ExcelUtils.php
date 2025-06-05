<?php

namespace Shared\Utils;

class ExcelUtils
{
    /**
     * Conversor de letras de columnas a número
     * Ejemplo: A -> 1, B -> 2, Z -> 26, AA -> 27, AB -> 28, ...
     * 
     * @param string $col
     * @return integer
     */
    public static function columnLettersToNumber(string $col): int
    {
        $col = strtoupper($col);
        $length = strlen($col);
        $number = 0;

        for ($i = 0; $i < $length; $i++) {
            $number *= 26; // Base 26
            $number += ord($col[$i]) - ord('A') + 1;
        }

        return $number;
    }


    /**
     * Transformación de tiempo de Excel a timestamp
     * 
     * @param int $excel_time
     * @return int
     */
    public static function convertExcelTImeToTimestamp(int $excel_time): int
    {
        return ($excel_time - 25569) * 86400;
    }
}
