<?php


namespace Hydro\Base\Model;


interface IDaoContract
{
    public static function getData();
    public function writeData();
    public function updateData();


}