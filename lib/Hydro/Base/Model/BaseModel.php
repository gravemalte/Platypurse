<?php

namespace Hydro\Base\Model;

use Hydro\Base\Database\Driver\SQLite;
use PDOException;


abstract class BaseModel  {

    private $table;
    private $tableColumns;

    /**
     * BaseModel constructor.
     * @param $table
     * @param $tableColumns
     */
    public function __construct($table, $tableColumns)
    {
        $this->table = $table;
        $this->tableColumns = $tableColumns;
    }

    public function writeToDatabase() {
        $con = SQLite::connectToSQLite();
        $result = false;
        $columns = $this->getTableColumns();

        try{
            // Check if object exists in database
            $objectInDatabase = $this->read($con, $this->getTable(). " WHERE " .reset($columns). " = ?", array($this->getId()));

            // If object doesn't exist, insert into database. Else update in database
            if(empty($objectInDatabase)):
                $result = $this->insertIntoDatabase($con);
            else:
                $result = $this->updateInDatabase($con);
            endif;

            if(!$result):
                throw new PDOException();
            endif;
        }
        catch(PDOException $ex) {
            $result = false;
        }
        finally {
            unset($con);
            return $result;
        }
    }
    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * @return mixed
     */
    public function getTableColumns()
    {
        return $this->tableColumns;
    }

    /**
     * @param mixed $tableColumns
     */
    public function setTableColumns($tableColumns)
    {
        $this->tableColumns = $tableColumns;
    }

}