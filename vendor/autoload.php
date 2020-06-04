<?php


// TODO: Rewrite the autoloader #4
spl_autoload_register(function ($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    if (strpos($className, 'Base') != false ||
        strpos($className, 'Helper') != false) {
        $includePath = ROOT . 'lib/' . $className . '.php';
        include $includePath;
    } else {
        $includePath = ROOT . 'app/' . $className . '.php';
        include $includePath;
    }
});