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
        $this->con = new PDO('sqlite:' . DB_FILE);
    }

    /**
     * Returns the current connection
     * @return PDO
     */
    public function getCon() {
        return $this->con;
    }

    /**
     * Begins transaction
     */
    public function openTransaction() {
        $this->con->beginTransaction();
    }

    /**
     * Close transaction, based on success
     * @param boolean $success
     */
    public function closeTransaction($success) {
        if($success):
            $this->con->commit();
        else:
            $this->con->rollback();
        endif;
    }
}