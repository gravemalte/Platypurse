<?php


namespace Hydro\Helper;


class DataSerialize
{
    /**
     * Returns an array ob unserialize object.
     * Cuts the last element out. See the in the FileWriter.php
     * for more information.
     *
     * @param $dataModell
     * @return array
     */
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