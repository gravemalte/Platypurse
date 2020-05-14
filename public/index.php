<?php


define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('LIB', ROOT . 'lib' . DIRECTORY_SEPARATOR);
define('CONFIG',  ROOT . 'config' . DIRECTORY_SEPARATOR);


// load application config (error reporting etc.)
require CONFIG . 'config.php';

// autoloader function, does load all classes except the main entry point see below
require ROOT . 'vendor/autoload.php';

// load application class
require APP . 'Application.php';

// boot the application
$app = new Application();