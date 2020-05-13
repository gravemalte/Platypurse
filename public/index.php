<?php

define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('LIB', ROOT . 'lib' . DIRECTORY_SEPARATOR);
define('CONF', ROOT . 'config' . DIRECTORY_SEPARATOR);


// load the config file database credentials etc.
require CONF . 'config.php';

// load of all classes mostly controllers
require APP . 'Application.php';
require LIB . 'Platypurse/Base/Controller/BaseController.php';
require LIB . 'Platypurse/Base/Model/BaseModel.php';

// start the application
$app = new Application();
