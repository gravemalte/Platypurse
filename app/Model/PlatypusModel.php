<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use PDOException;

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
        parent::__construct(TABLE_PLATYPUS, COLUMNS_PLATYPUS);
    }

    public function insertIntoDatabase($con) {
        return $this->create($con);
    }

    public static function getFromDatabase($con, $whereClause, $values) {
        $result = parent::read($con, TABLE_PLATYPUS. " " .$whereClause, $values);
        $platypus = array();

        foreach ($result as $row):
            $platypus[] = new PlatypusModel($row[COLUMNS_PLATYPUS["p_id"]],
                $row[COLUMNS_PLATYPUS["name"]],
                $row[COLUMNS_PLATYPUS["age_years"]],
                $row[COLUMNS_PLATYPUS["sex"]],
                $row[COLUMNS_PLATYPUS["size"]],
                $row[COLUMNS_PLATYPUS["weight"]],
                $row[COLUMNS_PLATYPUS["active"]]);
        endforeach;

        if(count($platypus) == 1):
            $platypus = array_shift($platypus);
        endif;

        return $platypus;
    }
    
    public function updateInDatabase($con, $editDate = true) {
        $result = false;

        try {
            $updateValues = $this->getDatabaseValues();
            $updateValues[] = $this->getId();
            $result = $this->update($con, $updateValues);
        }
        catch (PDOException $ex) {
            $con->rollBack();
            $result = false;
        }
        finally {
            unset($con);
            return $result;
        }
    }

    /**
     * Set active to 0 and update database
     */
    public function deactivateInDatabase() {
        $this->setActive(0);
        $this->updateInDatabase(SQLite::connectToSQLite());
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