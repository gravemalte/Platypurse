<?php


define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('LIB', ROOT . 'lib' . DIRECTORY_SEPARATOR);
define('CONFIG',  ROOT . 'config' . DIRECTORY_SEPARATOR);


// load application config (error reporting etc.)
require CONFIG . 'config.php';


// load application class
require APP . 'Application.php';


require LIB . 'Platypurse/Base/Controller/BaseController.php';
require LIB . 'Platypurse/Base/Model/BaseModel.php';

// start the application
$app = new Application();