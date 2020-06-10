<?php

define('ENVIRONMENT', 'dev');
if (ENVIRONMENT == 'dev') {
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

// Database configuration
define('DB_FILE_NAME', 'platypurse.sqlite');
define('DB_FILE', DB . DB_FILE_NAME);

define('URL_PUBLIC_FOLDER', 'public');
define('URL_PROTOCOL', '//');
define('URL_DOMAIN', $_SERVER['HTTP_HOST']);
define('URL_SUB_FOLDER', str_replace(URL_PUBLIC_FOLDER, '', dirname($_SERVER['SCRIPT_NAME'])));
define('URL', URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER);

// Database tablenames and rows
define("TABLE_LOG", "log");
define("COLUMNS_LOG", array("l_id" => "l_id",
    "message" => "message"));

define("TABLE_MESSAGE", "message");
define("COLUMNS_MESSAGE", array("msg_id" => "msg_id",
    "sender_id" => "sender_id",
    "receiver_id" => "receiver_id",
    "message" => "message",
    "send_date" => "send_date"));

define("TABLE_OFFER", "offer");
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

define("TABLE_OFFER_IMAGES", "offer_images");
define("COLUMNS_OFFER_IMAGES", array("oi_id" => "oi_id",
    "o_id" => "o_id",
    "picture_position" => "picture_position",
    "image" => "image"));

define("TABLE_OFFER_REPORTS", "offer_reports");
define("COLUMNS_OFFER_REPORTS", array("or_id" => "or_id",
    "reported_o_id" => "reported_o_id",
    "reportee_u_id" => "reportee_u_id",
    "rr_id" => "rr_id",
    "message" => "message"));


define("TABLE_PLATYPUS", "platypus");
define("COLUMNS_PLATYPUS", array("p_id" => "p_id",
    "name" => "name",
    "age_years" => "age_years",
    "sex" => "sex",
    "size" => "size",
    "active" => "active"));

define("TABLE_REPORT_REASONS", "report_reason");
define("COLUMNS_REPORTS_REASONS", array("rr_id" => "rr_id",
    "reason" => "reason"));

define("TABLE_SAVED_OFFERS", "saved_offers");
define("COLUMNS_SAVED_OFFERS", array("u_id" => "u_id",
    "o_id" => "o_id",
    "active" => "active"));

define("TABLE_USER", "user");
define("COLUMNS_USER", array(
    "u_id" => "u_id",
    "display_name" => "display_name",
    "mail" => "mail",
    "password" => "password",
    "ug_id" => "ug_id",
    "rating" => "rating",
    "created_at" => "created_at",
    "disabled" => "disabled"));

define("TABLE_USER_GROUP", "user_group");
define("COLUMNS_USER_GROUP", array("ug_id" => "ug_id",
    "name" => "name"));

define("TABLE_USER_RATING", "user_rating");
define("COLUMNS_USER_RATING", array("from_u_id" => "from_u_id",
    "for_u_id" => "for_u_id",
    "rating" => "rating"));

define("TABLE_USER_REPORTS", "user_reports");
define("COLUMNS_USER_REPORTS", array("ur_id" => "ur_id",
    "reported_u_id" => "reported_u_id",
    "reportee_u_id" => "reportee_u_id",
    "rr_id" => "rr_id",
    "message" => "message"));

