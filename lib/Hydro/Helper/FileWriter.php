<?php

namespace Hydro\Helper;

class FileWriter
{

    /**
     * Writes content to a file. Appending to it if it exists, if not
     * the file will be created.
     * @param $path
     * @param $content
     * @param string $mode
     */
    public static function writeToFile($path, $content)
    {
        if (!(file_exists($path))) {
            self::createFile($path);
        }
        $fileStream = fopen($path, "a+") or die('Opening Error');
        fwrite($fileStream, $content . "\n");
        fclose($fileStream);
    }

    public static function createFile($filePath){
        $file = fopen($filePath, "w") or die("Permission error, please check our environment");
        fwrite($file, "");
        fclose($file);

    }

    public static function fileIsEmpty($filePath){
        if(filesize($filePath) <= 0) return true; else{
            return false;
        }
    }

}