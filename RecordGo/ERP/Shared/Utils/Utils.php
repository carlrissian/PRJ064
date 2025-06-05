<?php

namespace Shared\Utils;

use DateTime;
use DateTimeZone;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\ValueObject\DateTimeValueObject;
use Shared\Repository\RepositoryHelper;

class Utils
{
    /**
     * @param $collection
     * @param string $key
     * @return array
     */
    public static function createSelect($collection, $key = 'id', $name = 'name'): array
    {
        $arrayList = [];
        foreach ($collection as $item) {
            $arrayList[] = [
                $key => $item->{"get" . $key}(),
                $name => $item->{"get" . $name}()
            ];
        }
        return $arrayList;
    }

    /**
     * @param $collection
     * @param string $key
     * @return array
     */
    public static function createCustomSelectList($collection, ...$values): array
    {
        $selectListArray = [];
        foreach ($collection as $item) {
            $itemArray = [];
            foreach ($values as $value) {
                if (str_contains($value, '.')) {
                    $value = explode('.', $value);
                    $firstItem = $item->{"get" . $value[0]}();
                    $itemArray[$value[0] . ucwords(strtolower($value[1]))] = $firstItem ? $firstItem->{"get" . $value[1]}() : $firstItem;
                } else {
                    $itemArray[$value] = $item->{"get" . $value}();
                }
            }
            $selectListArray[] = $itemArray;
        }
        return $selectListArray;
    }

    /**
     * @param string $odataDate
     */
    public static function convertOdataDateToDateTime(string $odataDate): \DateTime
    {
        // Regex to obtain the timestamp
        $pattern = "(-\d+|\d+)";
        preg_match($pattern, $odataDate, $matches);

        $date = new \DateTime();
        $date->setTimeStamp(((int) $matches[0]) / 1000);

        return $date;
    }

    public static function convertOdataTimeToMinutes(string $odataTime): int
    {
        // Regex to obtain the timestamp
        $exp = "/PT(\d{1,2})H(\d{1,2})M(\d{1,2})S/";

        preg_match($exp, $odataTime, $matches);

        $hours = $matches[1]; // Obtener las horas
        $minutes = $matches[2]; // Obtener los minutos
        $seconds = $matches[3]; // Obtener los segundos

        return intval($hours) * 60 + intval($minutes);
    }

    public static function formatMinutesToOdataTime(int $minutes): string
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes % 60;

        return "PT{$hours}H{$minutes}M0S";
    }

    public static function formatStringDateTimeToOdataDate(string $dateTime, ?string $format = 'd/m/Y'): string
    {
        $dateTime = DateTime::createFromFormat($format, $dateTime);
        return '/Date(' . $dateTime->getTimestamp() . '000)/';
    }

    /**
     * Convertir el string DateTime de un DateValueObject a un timestamp para OData
     * al que se le establece 0 horas 0 minutos y 0 segundos
     *
     * @param string $dateTime
     * @param string|null $format
     * @return string
     */
    public static function formatDateToFirstMinuteDateTime(string $date, ?string $format = 'd/m/Y'): string
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        $dateTime->setTime(0, 0, 0);
        return "/Date({$dateTime->getTimestamp()}000)/";
    }

    /**
     * Convertir el string DateTime de un DateValueObject a un timestamp para OData
     * al que se le suma 23 horas 59 minutos y 59 segundos
     *
     * @param string $dateTime
     * @param string|null $format
     * @return string
     */
    public static function formatDateToLastMinuteDateTime(string $date, ?string $format = 'd/m/Y'): string
    {
        $dateTime = DateTime::createFromFormat($format, $date);
        $dateTime->setTime(23, 59, 59);
        return "/Date({$dateTime->getTimestamp()}999)/";
    }

    /**
     * @param integer $timestamp
     * @return string
     */
    public static function formatTimestampToOdataDate(int $timestamp): string
    {
        if (!is_numeric($timestamp) || $timestamp < 0) {
            throw new \InvalidArgumentException("Invalid timestamp provided.");
        }
        return sprintf('/Date(%d000)/', $timestamp);
    }

    /**
     * Función para generar estructura Filtro y Paginación para repositorios (GetBy)
     * 
     * @param Criteria $criteria
     * @return array
     */
    public static function createCriteria(Criteria $criteria): array
    {
        return RepositoryHelper::createCriteria($criteria);
    }

    /**
     * @param array $request
     * @return string
     */
    public static function createQueryParams(array $request): string
    {
        $query = '';
        foreach ($request as $key => $value) {
            $query .= empty($query) ? '?' : '&';
            $query .= urlencode($key) . '=' . urlencode($value);
        }
        return $query;
    }
    public static function actualDateWithTimezone()
    {
        $timezone = $_SESSION['UserInfo']['timezone'];

        $date = new DateTime();
        $newTimezone = new DateTimeZone($timezone);
        $date->setTimezone($newTimezone);

        $newDate = new DateTimeValueObject($date);
        return $newDate;
    }


    /**
     * @param $collection
     * @param string $key
     * @return array
     */
    public static function createSelectWithFormattedName( 
        iterable $collection,
        string $idField,
        string $mainNameField,
        string $suffixNameField,
        array $extraFields = [],
        string $labelKey = 'name'
    ): array
    {
        $selectList = [];

        foreach ($collection as $item) {
            $entry = [];

            // ID
            $entry[$idField] = $item->{"get" . ucfirst($idField)}();

            // Campo combinado
            $main = $item->{"get" . ucfirst($mainNameField)}();
            $suffix = $item->{"get" . ucfirst($suffixNameField)}();
            $entry[$labelKey] = $suffix!="" ? trim("$main ($suffix)") : $main;
            // Campo acrissLetter por separado
            $entry[$suffixNameField] = $suffix;

            // Otros campos opcionales
            foreach ($extraFields as $field) {
                $entry[$field] = $item->{"get" . ucfirst($field)}();
            }

            $selectList[] = $entry;
        }

        return $selectList;
    }
}
