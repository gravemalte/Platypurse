<?php


namespace Hydro\Base\Database\Driver;

use PDO;

class SQLite
{
    private $con;

    /**
     * SQLite constructor.
     */
    public function __construct()
    {
        $this->con = new PDO('sqlite:' . DB_FILE);;
    }

    public function getCon() {
        return $this->con;
    }

    public function openTransaction() {
        $this->con->beginTransaction();
    }

    public function closeTransaction($success) {
        if($success):
            $this->con->commit();
        else:
            $this->con->rollback();
        endif;
    }
}