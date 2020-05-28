<?php

namespace Hydro\Helper;

class FileWriter
{

    /**
     * Writes content to a file. Appending to it if it exists, if not
     * the file will be created.
     * @param $path
     * @param $content
     */
    public static function writeToFile($path, $content) {
        $fileStream = fopen($path, "a+");
        fwrite($fileStream, $content . "\n");
        fclose($fileStream);
    }

    public static function readOutOfFile($path){
        $fileStream = fopen($path, "r");

    }

}