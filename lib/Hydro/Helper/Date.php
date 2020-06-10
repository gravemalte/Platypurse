<?php

namespace Hydro\Helper;

use DateTime;

class Date
{
    /**
     * @return false|string Date in Format YYYY-MM-DD HH:MM:SS
     */
    public static function now()
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * Returns a beautiful timestamp based on relative time.
     *
     * @param $timestamp
     * @return string
     */
    public static function niceDate($timestamp) {
        $date = DateTime::createFromFormat("Y-m-d H:i:s", $timestamp);
        $now = DateTime::createFromFormat("Y-m-d H:i:s", Date::now());

        $date_year = intval($date->format("Y"));
        $date_month = intval($date->format("n"));
        $date_day = intval($date->format("j"));
        $date_hour = intval($date->format("G"));

        $now_year = intval($now->format("Y"));
        $now_month = intval($now->format("n"));
        $now_day = intval($now->format("j"));
        $now_hour = intval($now->format("G"));

        if ($date_year == $now_year) {
            if ($date_month == $now_month) {
                if ($date_day == $now_day) {
                    if ($date_hour == $now_hour) {
                        return "gerade eben";
                    }
                    return "Heute um " . $date->format("H:i");
                }
                if ($date_day + 1 == $now_day) {
                    return "Gestern um " . $date->format("H:i");
                }
                return "am " .$date->format("j") . " um " . $date->format("H:i");
            }
            return $date->format("d.m.") . " um " . $date->format("H:i");
        }
        return $date->format("d.m.Y") . " um " . $date->format("H:i");
    }

}