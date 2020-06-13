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

    /** Run statement on the database.
     * @param string $statement to run.
     * @param array $values to insert into prepared statement. Optional
     * @return array|bool
     */
    public static function runStatement($statement, $values=array()) {
        $htmlSpecialCharsValue = array();
        foreach ($values as $val):
            $htmlSpecialCharsValue[] = htmlspecialchars($val);
        endforeach;

        $con = self::connectToSQLite();
        $result = array();

        try {
            $con->beginTransaction();
            $command = $con->prepare(htmlspecialchars($statement));
            $result = $command->execute($htmlSpecialCharsValue);

            if(substr($statement, 0, 6) == "SELECT"):
                $result = $command->fetchAll();
            endif;

            $con->commit();
        }
        catch (PDOException $ex) {
            $con->rollback();
            return $result;
        }
        finally {
            unset($con);
            return $result;
        }
    }

    /** Build a SELECT query from the given parameters
     *
     * @param array $columns to query.
     * @param string $whereClause contains table to select from.
     * @param string $preparedWhereClause Optional.
     * @param array $values Optional, necessary if $preparedWhereClause is given.
     * @param string $groupClause Optional.
     * @param string $orderClause Optional.
     * @param string $limitClause Optional
     * @return array|string
     */
    public static function selectBuilder($columns, $whereClause, $preparedWhereClause = "", $values = array(), $groupClause = "",
                                         $orderClause = "", $limitClause = "") {
        $statement = "SELECT ";

        foreach($columns as $selVal) {
            $statement .= $selVal. ", ";
        }

        $statement = substr($statement, 0, -2)." FROM " .$whereClause;

        if(!empty($preparedWhereClause)):
            $statement .= " WHERE " .$preparedWhereClause;
        endif;

        if(!empty($groupClause)):
            $statement .= " GROUP BY " .$groupClause;
        endif;

        if(!empty($orderClause)):
            $statement .= " ORDER BY " .$orderClause;
        endif;

        if(!empty($limitClause)):
            $statement .= " LIMIT " .$limitClause;
        endif;

        $statement .= ";";

        //print($statement);
        //print_r($values);

        return self::runStatement($statement, $values);
    }

    /** Buils a INSERT query from the given parameters.
     *
     * @param string $table to execute query on.
     * @param array $columns to insert values in.
     * @param array $values to insert into columns.
     * @return bool
     */
    public static function insertBuilder($table, $columns, $values) {
        $statement = "INSERT INTO ".$table." (";

        // Add inserted columns to statement
        foreach($columns as $col) {
            $statement .= $col. ", ";
        }

        // Edit statement to match 'VALUES (col1, col2, ...)' pattern
        $statement = substr($statement, 0, -2).") VALUES (";

        foreach($values as $val) {
            $statement .= "?, ";
        }

        $statement = substr($statement, 0, -2);
        if(substr($statement, -1) != ")"): $statement .= ")"; endif;
        $statement .= ";";

        //print($statement);
        //print_r($values);

        return self::runStatement($statement, $values);
    }

    /** Builds a UPDATE query from the given parameters.
     *
     * @param string $table to execute query on.
     * @param string $preparedSetClause to update on.
     * @param string $preparedWhereClause to update on.
     * @param array $values to update.
     * @return bool
     */
    public static function updateBuilder($table, $preparedSetClause, $preparedWhereClause, $values) {
        $statement = "UPDATE " .$table. " SET " .$preparedSetClause. " WHERE " .$preparedWhereClause. ";";

        //print($statement);
        //print_r($values);

        return self::runStatement($statement, $values);
    }

    /** Buils a DELETE query from the given parameters.
     *
     * @param string $table to execute query on.
     * @param string $preparedWhereClause to define the deleting rows.
     * @param array $values to define the deleting rows.
     * @return bool
     */
    public static function deleteBuilder($table, $preparedWhereClause, $values) {
        $statement = "DELETE FROM " .$table. " WHERE " .$preparedWhereClause.";";

        return self::runStatement($statement, $values);
    }
}