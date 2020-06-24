<?php

/**
 * Checks if the web server has enable 'mod_rewrite'
 */
if(!in_array('mod_rewrite', apache_get_modules())){
    exit("<b>Please enable mod_rewrite in you Apache!
    Stopping startup.</b>");
}
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
define('CONFIG',  ROOT . 'config' . DIRECTORY_SEPARATOR);

// load the application config (error reporting, constants, etc.)
require CONFIG . 'config.php';

// autoloader function, does load all classes except the main entry point see below
require ROOT . 'vendor/autoload.php';

// load application class
require APP . 'Application.php';

if(!file_exists(DB_FILE)){
    $database = new PDO('sqlite:' . DB_FILE);
    // Create tables
    $sql_file_name = DB . 'sql/create_tables.sql';
    $sql_file = file_get_contents($sql_file_name);
    $database->exec($sql_file);
    // Fill tables
    $sql_file_name = DB . 'sql/fill_tables.sql';
    $sql_file = file_get_contents($sql_file_name);
    $database->exec($sql_file);
    sleep(2);
    unset($database);
}

ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);

session_start();
session_get_cookie_params();

// boot the application
$app = Application::getInstance();