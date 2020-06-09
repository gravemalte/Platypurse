<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;

class PlatypusModel extends BaseModel {
    const TABLE = "platypus";
    const TABLECOLUMNS = array("p_id" => "p_id",
        "name" => "name",
        "age_years" => "age_years",
        "sex" => "sex",
        "size" => "size");

    private $id;
    private $name;
    private $age_years;
    private $sex;
    private $size;

    /**
     * PlatypusModel constructor.
     * @param $id
     * @param $name
     * @param $age_years
     * @param $sex
     * @param $size
     */
    public function __construct($id, $name, $age_years, $sex, $size)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age_years = $age_years;
        $this->sex = $sex;
        $this->size = $size;
        parent::__construct();
    }

    public static function getFromDatabase($preparedWhereClause = "", $values = array(),
                                           $groupClause = "", $orderClause = "", $limitClause = "") {
        $platypus = array();
        $result = SQLite::selectBuilder(self::TABLECOLUMNS,
            self::TABLE,
            $preparedWhereClause,
            $values,
            $groupClause,
            $orderClause,
            $limitClause);

        foreach ($result as $row):
            $platypus[] = new PlatypusModel($row[self::TABLECOLUMNS["p_id"]],
                $row[self::TABLECOLUMNS["name"]],
                $row[self::TABLECOLUMNS["age_years"]],
                $row[self::TABLECOLUMNS["sex"]],
                $row[self::TABLECOLUMNS["size"]]);
        endforeach;

        if(sizeof($platypus) <= 1):
            return array_shift($platypus);
        else:
            return $platypus;
        endif;
    }

    public function writeToDatabase() {
        // Check if platypus exists in database
        $platypusInDatabase = SQLite::selectBuilder(self::TABLECOLUMNS, self::TABLE,
            self::TABLECOLUMNS["p_id"]. " = ?", array($this->getId()));

        // If platypus doesn't exist, insert into database. Else update in database
        if(empty($platypusInDatabase)):
            return $this->insertIntoDatabase();
        else:
            return $this->updateInDatabase();
        endif;
    }

    /**
     * @return bool
     */
    public function insertIntoDatabase() {
        return SQLite::insertBuilder(self::TABLE,
            self::TABLECOLUMNS,
            $this->getDatabaseValues());
    }

    /**
     *
     */
    public function updateInDatabase() {
        $preparedSetClause = "";
        foreach (self::TABLECOLUMNS as $tableCol):
            $preparedSetClause .= $tableCol. " = ?,";
        endforeach;

        $preparedWhereClause = self::TABLECOLUMNS["p_id"]. " = " .$this->getId();

        return SQLite::updateBuilder(self::TABLE,
            substr($preparedSetClause, 0, -1),
            $preparedWhereClause,
            $this->getDatabaseValues());
    }

    /**
     *
     */
    public function deleteFromDatabase() {
       return SQLite::deleteBuilder(self::TABLE,
            self::TABLECOLUMNS['p_id']. " = ?;",
            array($this->getId()));
    }

    /**
     * @return array
     */
    public function getDatabaseValues() {
        return array($this->getId(),
            $this->getName(),
            $this->getAgeYears(),
            $this->getSex(),
            $this->getSize());
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAgeYears()
    {
        return $this->age_years;
    }

    /**
     * @param mixed $age_years
     */
    public function setAgeYears($age_years): void
    {
        $this->age_years = $age_years;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size): void
    {
        $this->size = $size;
    }
}