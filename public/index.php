<?php


define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('LIB', ROOT . 'lib' . DIRECTORY_SEPARATOR);
define('CONFIG',  ROOT . 'config' . DIRECTORY_SEPARATOR);
define('DB', ROOT . 'db' . DIRECTORY_SEPARATOR);


// load application config (error reporting etc.)
require CONFIG . 'config.php';

// autoloader function, does load all classes except the main entry point see below
require ROOT . 'vendor/autoload.php';

// load application class
require APP . 'Application.php';

if(!in_array('mod_rewrite', apache_get_modules())){
    exit("<b>Please enable mod_rewrite in you Apache!
    Stopping startup.</b>");
}

session_start();
session_get_cookie_params();

// boot the application
$app = Application::getInstance();