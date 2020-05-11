<?php

namespace vendor\autoload;

use BadFunctionCallException;

function autoload($className){
    $includePaths = explode(PATH_SEPARATOR, get_include_path());

    $flags = PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE;
    $filePath = strtolower(str_replace("\\", DIRECTORY_SEPARATOR,
            trim($className, "\\"))).".php";
    foreach ($includePaths as $path){
        $fullPath = $path.DIRECTORY_SEPARATOR.$filePath;
        if(file_exists($fullPath)) {
            include($fullPath);
            return;
        }
        throw new BadFunctionCallException("Include error! File:". $fullPath. "not found!");
    }
}