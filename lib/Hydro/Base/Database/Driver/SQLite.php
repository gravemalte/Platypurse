<?php


namespace Hydro\Base\Database\Driver;

use PDO;
use PDOException;

class SQLite
{

    public static function connectToSQLite(){
        return new PDO('sqlite:' . DB_FILE);
    }

    public static function queryStmnt($stmnt, $values) {
        $con = self::connectToSQLite();
        $result = "";
        try {
            $command = $con->prepare($stmnt);
            $command->execute($values);
            $result = $command->fetchAll();
        }
            // TODO: Error handling db execute
        catch (PDOException $ex) {
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

    public static function selectBuilder($selectedValues, $fromClause, $preparedWhereClause = "", $values= "", $groupClause = "",
                                         $orderClause = "", $limitClause = "") {
        $stmnt = "SELECT ";

        foreach($selectedValues as $selVal) {
            $stmnt .= $selVal. ", ";
        }

        $stmnt = substr($stmnt, 0, -2)." FROM "
            .$fromClause;

        if(!empty($preparedWhereClause)):
            $stmnt .= " WHERE " .$preparedWhereClause;
        endif;

        if(!empty($groupClause)):
            $stmnt .= " GROUP BY " .$groupClause;
        endif;

        if(!empty($orderClause)):
            $stmnt .= " ORDER BY " .$orderClause;
        endif;

        if(!empty($limitClause)):
            $stmnt .= " LIMIT " .$limitClause;
        endif;

        $stmnt .= ";";

        return self::queryStmnt($stmnt, $values);
    }

    public static function insertBuilder($table, $columns, $values) {
        $stmnt = "INSERT INTO ".$table." (";

        // Add inserted columns to statement
        foreach($columns as $col) {
            $stmnt .= $col. ", ";
        }

        // Edit statement to match 'VALUES (col1, col2, ...)' pattern
        $stmnt = substr($stmnt, 0, -2).") VALUES (";

        foreach($values as $val) {
            $stmnt .= "?, ";
        }

        $stmnt = substr($stmnt, 0, -2);
        if(substr($stmnt, -1) != ")"): $stmnt .= ")"; endif;
        $stmnt .= ";";

        return self::execStmnt($stmnt, $values);
    }

    public static function updateBuilder($table, $preparedSetClause, $preparedWhereClause, $values) {
        $stmnt = "UPDATE " .$table. " SET " .$preparedSetClause. " WHERE " .$preparedWhereClause. ";";

        // print($stmnt);
        // print_r($values);

        return self::execStmnt($stmnt, $values);
    }

    public static function deleteBuilder($table, $preparedWhereClause, $values) {
        $stmnt = "DELETE FROM " .$table. " WHERE " .$preparedWhereClause.";";

        return self::execStmnt($stmnt, $values);
    }
}