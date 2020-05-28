<?php


namespace Hydro\Helper;


class DataSerialize
{
    public static function unserializeData($dataModell){
        $dataArray = array();
        foreach ($dataModell as $data){
            $obj = unserialize($data);
            array_push($dataArray, $obj);
        }
        unset($dataArray[sizeof($dataArray) - 1]);
        return $dataArray;
    }

}