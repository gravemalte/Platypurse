<?php


namespace Platypurse\Helper;


class Arrays
{
    private function __construct()
    {
    }

    public static function removeAll($array){
        return array_filter($array, function ($item){
            return !empty($item);
        });
    }

}