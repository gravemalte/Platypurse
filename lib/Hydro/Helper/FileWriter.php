<?php

namespace Hydro\Helper;

class FileWriter
{

    public static function writeToFile($path, $content) {
        $fileStream = fopen($path, "a+");
        fwrite($fileStream, $content . "\n");
        fclose($fileStream);
    }

    public static function readOutOfFile($path){
        $fileStream = fopen($path, "r");

    }

}