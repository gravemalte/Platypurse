<?php

namespace vendor\Autoloader;

use function vendor\autoload\autoload;

class Autoloader{
    public static function autoload($className){
        autoload($className);
    }
}
