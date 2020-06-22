<?php

namespace Hydro\Base\Model;

use Hydro\Base\Contracts\DAOContract;
use Hydro\Base\Database\Driver\SQLite;
use Model\UserModel;
use Hydro\Helper\AbstractBaseClass;
use PDOException;


abstract class BaseModel extends AbstractBaseClass implements DAOContract  {

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

    public function create($con)
    {
        $statement = "INSERT INTO " .$this->getTable(). " (";
        foreach ($this->getTableColumns() as $col):
            $statement .= $col .", ";
        endforeach;
        $statement = substr($statement, 0, -2) .") VALUES (";
        $specialCharsValueArray = array();
        foreach ($this->getDatabaseValues() as $val):
            $statement .= "?, ";
            $specialCharsValueArray[] = $val;
        endforeach;
        $statement = substr($statement, 0, -2) .");";
        $command = $con->prepare($statement);

        return $command->execute($specialCharsValueArray);
    }

    public static function read($con, $whereClause = "", $values = array())
    {
        $statement = "SELECT * FROM " .$whereClause;

        //print($statement);
        //print_r($values);

        $command = $con->prepare($statement);
        $command->execute($values);

        return $command->fetchAll();
    }

    public function update($con, $values)
    {
        $columns = $this->getTableColumns();
        $statement = "UPDATE " .$this->getTable(). " SET ";
        foreach ($this->getTableColumns() as $col):
            $statement .= $col ." = ?, ";
        endforeach;
        $statement = substr($statement, 0, -2) ." WHERE " .reset($columns). " = ?;";
        $specialCharsValueArray = array();
        foreach ($values as $val):
            $specialCharsValueArray[] = $val;
        endforeach;

        $command = $con->prepare($statement);
        return $command->execute($specialCharsValueArray);
    }

    public function delete($con, $values)
    {
        $columns = $this->getTableColumns();
        $statement = "DELETE FROM " .$this->getTable(). " WHERE " .reset($columns). " = ?;";

        $command = $con->prepare($statement);
        return $command->execute($values);
    }

    public function writeToDatabase() {
        $con = SQLite::connectToSQLite();
        $result = false;
        $columns = $this->getTableColumns();

        try{
            $con->beginTransaction();
            // Check if object exists in database
            $objectInDatabase = $this->read($con, $this->getTable(). " WHERE " .reset($columns). " = ?", array($this->getId()));

            // If object doesn't exist, insert into database. Else update in database
            if(empty($objectInDatabase)):
                $result = $this->insertIntoDatabase($con);
            else:
                $result = $this->updateInDatabase($con);
            endif;

            if($result):
                $con->commit();
            else:
                throw new PDOException();
            endif;
        }
        catch(PDOException $ex) {
            $con->rollBack();
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
    public function setTable($table): void
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
    public function setTableColumns($tableColumns): void
    {
        $this->tableColumns = $tableColumns;
    }

}