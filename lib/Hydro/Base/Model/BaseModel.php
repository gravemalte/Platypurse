<?php

namespace Hydro\Base\Model;

use Hydro\Base\Database\Driver\SQLite;


class BaseModel implements IDaoContract {


    public $db;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $this->db = SQLite::connectToSQLite();
    }


    public static function getData()
    {
    }

    public function writeData()
    {
    }

    public function updateData()
    {
    }
}