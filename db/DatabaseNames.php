<?php

namespace Hydro\Helper;

class DatabaseNames
{
    const LOGTABLE = "log";
    const LOGABLECOLUMNS = array("l_id" => "l_id",
        "message" => "message");

    const MESSAGETABLE = "message";
    const MESSAGETABLECOLUMNS = array("msg_id" => "msg_id",
        "mt_id" => "mt_id",
        "send_date" => "send_date",
        "text" => "text",
        "sending_u_id" => "sending_u_id");

    const MSGTHREADTABLE = "msg_thread";
    const MSGTHREADTABLECOLUMNS = array("mt_id" => "mt_id");

    const OFFER = "message";
    const OFFERTABLECOLUMNS = array("o_id" => "o_id",
        "u_id" => "u_id",
        "p_id" => "p_id",
        "price" => "price",
        "negotiable" => "negotiable",
        "description" => "description",
        "clicks" => "clicks",
        "create_date" => "create_date",
        "edit_date" => "edit_date",
        "active" => "active");

    const OFFERIMAGETABLE = "offer_images";
    const OFFERIMAGETABLECOLUMNS = array("oi_id" => "oi_id",
        "o_id" => "o_id",
        "picture_position" => "picture_position",
        "image" => "image");

    const OFFERREPORTSTABLE = "offer_reports";
    const OFFERREPORTSTABLECOLUMNS = array("or_id" => "or_id",
        "reported_o_id" => "reported_o_id",
        "reportee_u_id" => "reportee_u_id",
        "rr_id" => "rr_id",
        "message" => "message");


    const PLATYPUSTABLE = "platypus";
    const PLATYPUSTABLECOLUMNS = array("p_id" => "p_id",
        "name" => "name",
        "age_years" => "age_years",
        "sex" => "sex",
        "size" => "size");

    const REPORTREASONTABLE = "report_reason";
    const REPORTREASONTABLECOLUMNS = array("rr_id" => "rr_id",
        "reason" => "reason");

    const SAVEDOFFERSTABLE = "saved_offers";
    const SAVEDOFFERSTABLECOLUMNS = array("u_id" => "u_id",
        "o_id" => "o_id",
        "active" => "active");

    const THREADUSERTABLE = "thread_user";
    const THREADUSERTABLECOLUMNS = array("u_id" => "u_id",
        "mt_id" => "mt_id");

    const USERTABLE = "user";
    const USERTABLECOLUMNS = array(
        "u_id" => "u_id",
        "display_name" => "display_name",
        "mail" => "mail",
        "password" => "password",
        "ug_id" => "ug_id",
        "rating" => "rating",
        "created_at" => "created_at",
        "disabled" => "disabled");

    const USERGROUPTABLE = "user_group";
    const USERGROUPTABLECOLUMNS = array("ug_id" => "ug_id",
        "name" => "name");

    const USERRATINGTABLE = "user_rating";
    const USERRATINGTABLECOLUMNS = array("from_u_id" => "from_u_id",
        "for_u_id" => "for_u_id",
        "rating" => "rating");

    const USERREPORTSTABLE = "user";
    const USERREPORTSTABLECOLUMNS = array("ur_id" => "ur_id",
        "reported_u_id" => "reported_u_id",
        "reportee_u_id" => "reportee_u_id",
        "rr_id" => "rr_id",
        "message" => "message");
}