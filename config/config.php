<?php

define('ENVIRONMENT', 'dev');
if (ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}


/**
 * Constant definitions for our directories
 */

define('APP', ROOT . 'app' . DIRECTORY_SEPARATOR);
define('LIB', ROOT . 'lib' . DIRECTORY_SEPARATOR);
define('DB', ROOT . 'db' . DIRECTORY_SEPARATOR);
define('BACKSLASH', '\\');

/**
 * URL configuration for the web server
 */

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);


/**
 * Database configuration
 */

define('DB_FILE_NAME', 'platypurse.sqlite');
define('DB_FILE', DB . DB_FILE_NAME);
