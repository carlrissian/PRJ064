<?php

namespace App\Validator;


class ImportSeasonValidator
{
    public function validateNumericField($value){
        return is_numeric($value);
    }

    public function validateActiveAcriss($acrissNameList, $acrissInRepository){

        return count(array_diff($acrissNameList, $acrissInRepository))===0;
    }

    public function validateRangeCollection($arcCollection){
        for($i=1; count($arcCollection)>$i; $i++){
            if($arcCollection[$i-1]['maxDays']+1!==$arcCollection[$i]['minDays'])
                return false;
        }

        return true;
    }

}