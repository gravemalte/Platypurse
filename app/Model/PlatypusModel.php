<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;

class PlatypusModel extends BaseModel {
    private $id;
    private $name;
    private $age_years;
    private $sex;
    private $size;
    private $weight;
    private $active;

    /**
     * PlatypusModel constructor.
     * @param $id
     * @param $name
     * @param $age_years
     * @param $sex
     * @param $size
     * @param $weight
     * @param $active
     */
    public function __construct($id, $name, $age_years, $sex, $size, $weight, $active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age_years = $age_years;
        $this->sex = $sex;
        $this->size = $size;
        $this->weight = $weight;
        $this->active = $active;
        parent::__construct();
    }


    public function create()
    {
        // TODO: Implement create() method.
    }

    public function read()
    {
        // TODO: Implement read() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }


    public static function getFromDatabase($preparedWhereClause = "", $values = array(),
                                           $groupClause = "", $orderClause = "", $limitClause = "") {
        $platypus = array();
        $result = SQLite::selectBuilder(COLUMNS_PLATYPUS,
            TABLE_PLATYPUS,
            $preparedWhereClause,
            $values,
            $groupClause,
            $orderClause,
            $limitClause);

        foreach ($result as $row):
            $platypus[] = new PlatypusModel($row[COLUMNS_PLATYPUS["p_id"]],
                $row[COLUMNS_PLATYPUS["name"]],
                $row[COLUMNS_PLATYPUS["age_years"]],
                $row[COLUMNS_PLATYPUS["sex"]],
                $row[COLUMNS_PLATYPUS["size"]],
                $row[COLUMNS_PLATYPUS["weight"]],
                $row[COLUMNS_PLATYPUS["active"]]);
        endforeach;

        if(sizeof($platypus) <= 1):
            return array_shift($platypus);
        else:
            return $platypus;
        endif;
    }

    public function writeToDatabase() {
        // Check if platypus exists in database
        $platypusInDatabase = SQLite::selectBuilder(COLUMNS_PLATYPUS, TABLE_PLATYPUS,
            COLUMNS_PLATYPUS["p_id"]. " = ?", array($this->getId()));

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
        return SQLite::insertBuilder(TABLE_PLATYPUS,
            COLUMNS_PLATYPUS,
            $this->getDatabaseValues());
    }

    /**
     *
     */
    public function updateInDatabase() {
        $preparedSetClause = "";
        foreach (COLUMNS_PLATYPUS as $tableCol):
            $preparedSetClause .= $tableCol. " = ?,";
        endforeach;

        $preparedWhereClause = COLUMNS_PLATYPUS["p_id"]. " = " .$this->getId();

        return SQLite::updateBuilder(TABLE_PLATYPUS,
            substr($preparedSetClause, 0, -1),
            $preparedWhereClause,
            $this->getDatabaseValues());
    }

    /**
     * Set active to 0 and update database
     */
    public function deleteFromDatabase() {
        $this->setActive(0);
        return $this->updateInDatabase();
    }

    /**
     * @return array
     */
    public function getDatabaseValues() {
        return array($this->getId(),
            $this->getName(),
            $this->getAgeYears(),
            $this->getSex(),
            $this->getSize(),
            $this->getWeight(),
            $this->getActive());
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

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param mixed $size
     */
    public function setWeight($weight): void
    {
        $this->weight = $weight;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }
}