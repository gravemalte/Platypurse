<?php

namespace Hydro\Helper;

abstract class AbstractBaseClass {
    abstract public function insertIntoDatabase($con);
    abstract public static function getFromDatabase($con, $whereClause, $value);
    abstract public function updateInDatabase($con, $editDate = true);
    abstract public function deactivateInDatabase();
    abstract public function writeToDatabase();
    abstract public function getDatabaseValues();
    abstract public function getId();
}