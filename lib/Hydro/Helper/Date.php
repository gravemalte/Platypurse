<?php

namespace Hydro\Helper;

class Date
{
    /**
     * @return false|string Date in Format YYYY-MM-DD HH:MM:SS
     */
    public static function now()
    {
        return date("Y-m-d H:i:s");
    }

}