<?php


namespace Hydro\Base\Database\Driver;

use PDO;
use PDOException;

class SQLite
{

    public static function connectToSQLite(){
        return new PDO('sqlite:' . DB_FILE);
    }

    public static function queryStmnt($stmnt) {
        $con = self::connectToSQLite();
        $result = "";
        try {
            $result = $con->query($stmnt);
        }
            // TODO: Error handling db execute
        catch (Exeption $ex) {
        }
        finally {
            unset($con);
            return $result;
        }
    }

    public static function execStmnt($stmnt, $values=array()) {
        $con = self::connectToSQLite();
        try {
            $con->beginTransaction();
            $command = $con->prepare($stmnt);
            $command->execute($values);
            $con->commit();
        }
        // TODO: Error handling db execute
        catch (PDOException $ex) {
            $con->rollback();
            return false;
        }
        finally {
            unset($con);
            return true;
        }
    }

    public static function select($query) {
        //TODO: Implement query builder for SELECT
        return self::queryStmnt($query);
    }

    public static function insertInto($table, $columns, $values) {
        $stmnt = "INSERT INTO ".$table." (";

        // Add inserted columns to statement
        foreach($columns as $col) {
            $stmnt .= $col. ", ";
        }

        // Edit statement to match 'VALUES (col1, col2, ...)' pattern
        $stmnt = substr($stmnt, 0, -2).") VALUES (";

        foreach($values as $val) {
            if(is_array($val)):
                $subStmnt = "";
                foreach($val as $v) {
                    $subStmnt .= "?, ";
                }
                $stmnt .= "(".substr($subStmnt, 0, -2)."), ";
            else:
                $stmnt .= "?, ";
            endif;
        }

        $stmnt = substr($stmnt, 0, -2);
        if(substr($stmnt, -1) != ")"): $stmnt .= ")"; endif;
        $stmnt .= ";";

        return self::execStmnt($stmnt, $values);
    }

    public static function updateBuilder($table, $preparedSetClause, $preparedWhereClause, $values) {
        $stmnt = "UPDATE " .$table. " SET " .$preparedSetClause. " WHERE " .$preparedWhereClause. ";";

        return self::execStmnt($stmnt, $values);
    }

    public static function deleteBuilder($table, $preparedWhereClause, $values) {
        $stmnt = "DELETE FROM " .$table. " WHERE " .$preparedWhereClause.";";

        return self::execStmnt($stmnt, $values);
    }

    public static function selectBuilder() {

    }
}