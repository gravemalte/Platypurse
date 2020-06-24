<?php


namespace Hydro\Base\Database\Driver;

use PDO;
use PDOException;

class SQLite
{

    /** Opens a connection to the database.
     * @return PDO
     */
    public static function connectToSQLite(){
        return new PDO('sqlite:' . DB_FILE);
    }
}