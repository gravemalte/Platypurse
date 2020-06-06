<?php


namespace Hydro\Base\Database\Driver;


use PDO;

class SQLite
{

    public static function connectToSQLite(){
        return new PDO('sqlite:' . DB_FILE);
    }

}