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

/**
 * Database definition's for tables and rows
 */

/** Table name for table "log" */
define("TABLE_LOG", "log");
/** Table columns for table "log" */
define("COLUMNS_LOG", array("l_id" => "l_id",
    "message" => "message"));

/** Table name for table "message" */
define("TABLE_MESSAGE", "message");
/** Table columns for table "message" */
define("COLUMNS_MESSAGE", array("msg_id" => "msg_id",
    "sender_id" => "sender_id",
    "receiver_id" => "receiver_id",
    "message" => "message",
    "send_date" => "send_date"));

/** Table name for table "offer" */
define("TABLE_OFFER", "offer");
/** Table columns for table "offer" */
define("COLUMNS_OFFER", array("o_id" => "o_id",
    "u_id" => "u_id",
    "p_id" => "p_id",
    "price" => "price",
    "negotiable" => "negotiable",
    "description" => "description",
    "clicks" => "clicks",
    "create_date" => "create_date",
    "edit_date" => "edit_date",
    "active" => "active"));

/** Table name for table "offer_images" */
define("TABLE_OFFER_IMAGES", "offer_images");
/** Table columns for table "offer_images" */
define("COLUMNS_OFFER_IMAGES", array("oi_id" => "oi_id",
    "o_id" => "o_id",
    "picture_position" => "picture_position",
    "mime" => "mime",
    "image" => "image"));

/** Table name for table "offer_reports" */
define("TABLE_OFFER_REPORTS", "offer_reports");
/** Table columns for table "offer_reports" */
define("COLUMNS_OFFER_REPORTS", array("or_id" => "or_id",
    "reported_o_id" => "reported_o_id",
    "reportee_u_id" => "reportee_u_id",
    "rr_id" => "rr_id",
    "message" => "message"));


/** Table name for table "platypus" */
define("TABLE_PLATYPUS", "platypus");
/** Table columns for table "platypus" */
define("COLUMNS_PLATYPUS", array("p_id" => "p_id",
    "name" => "name",
    "age_years" => "age_years",
    "sex" => "sex",
    "size" => "size",
    "weight" => "weight",
    "active" => "active"));

/** Table name for table "report_reason" */
define("TABLE_REPORT_REASONS", "report_reason");
/** Table columns for table "report_reason" */
define("COLUMNS_REPORTS_REASONS", array("rr_id" => "rr_id",
    "reason" => "reason"));

/** Table name for table "saved_offers" */
define("TABLE_SAVED_OFFERS", "saved_offers");
/** Table columns for table "saved_offers" */
define("COLUMNS_SAVED_OFFERS", array("u_id" => "u_id",
    "o_id" => "o_id",
    "active" => "active"));


/** Table name for table "user" */
define("TABLE_USER", "user");
/** Table columns for table "user" */
define("COLUMNS_USER", array(
    "u_id" => "u_id",
    "display_name" => "display_name",
    "mail" => "mail",
    "password" => "password",
    "ug_id" => "ug_id",
    "rating" => "rating",
    "created_at" => "created_at",
    "mime" => "mime",
    "image" => "image",
    "disabled" => "disabled"));

/** Table name for table "user_group" */
define("TABLE_USER_GROUP", "user_group");
/** Table columns for table "user_group" */
define("COLUMNS_USER_GROUP", array("ug_id" => "ug_id",
    "name" => "name"));

/** Table name for table "user_rating" */
define("TABLE_USER_RATING", "user_rating");
/** Table columns for table "user_rating" */
define("COLUMNS_USER_RATING", array("from_u_id" => "from_u_id",
    "for_u_id" => "for_u_id",
    "rating" => "rating"));

/** Table name for table "user_reports" */
define("TABLE_USER_REPORTS", "user_reports");
/** Table columns for table "user_reports" */
define("COLUMNS_USER_REPORTS", array("ur_id" => "ur_id",
    "reported_u_id" => "reported_u_id",
    "reportee_u_id" => "reportee_u_id",
    "rr_id" => "rr_id",
    "message" => "message"));

