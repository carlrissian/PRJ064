<?php

namespace Shared\Constants\Infrastructure;

use Shared\Domain\Logs\GrafanaLogHelper;

class ConstantsJsonFile
{

    public static function write($cosntantsArray, $country = null)
    {
        //Open json and write constantsArray if exists whitout overrading, if not create new file and write constantsArray
        $json = json_encode($cosntantsArray);
        file_put_contents(self::getFilePath($country), $json);
    }

    public static function getAllConstants($country = null){
        //si el fichero no existe devolver objeto vacio
        if(!file_exists(self::getFilePath($country))){
            return '{}';
        }

        return file_get_contents(self::getFilePath($country));
    }

    public static function getValue($key, $country = null)
    {
        $filePath = self::getFilePath($country);

        $logHelper = new GrafanaLogHelper();
        //Comprobar si el fichero existe
        if(!file_exists($filePath)){
            $logHelper->log('GET', 500, '', 'No existe fichero constantes', 'ERROR');
            return false;
        }
        //Open json and find key and return value
        $json = file_get_contents($filePath);

        $constantsArray = json_decode($json, true);

        if(!array_key_exists($key, $constantsArray)){
            $logHelper->log('GET', 500, '', 'No existe en fichero constantes la constante '.$key, 'ERROR');
            return false;
        }

        return $constantsArray[$key];
    }

    private static function getFilePath($country = null){
        if(!$country && isset($_SESSION['UserInfo']['countryIso'])){
            $country = $_SESSION['UserInfo']['countryIso'];
        }

        return './'.$country.'_constants.json';
    }
}