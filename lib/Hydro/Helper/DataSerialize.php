<?php


namespace Hydro\Helper;


class DataSerialize
{
    /**
     * Returns an array of unserialize objects.
     * Cuts the last element out. See the in the FileWriter.php
     * for more information.
     *
     * @param $dataModel
     * @return array
     */
    public static function unserializeData($dataModel)
    {
        $dataArray = array();
        if (is_array($dataModel)) {
            foreach ($dataModel as $data) {
                $obj = unserialize($data);
                array_push($dataArray, $obj);
            }
            unset($dataArray[sizeof($dataArray) - 1]);
            return $dataArray;
        }
        return array();
    }

    public static function serializeData($dataModel)
    {
        return serialize($dataModel);
    }

}