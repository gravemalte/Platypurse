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

    public function writeToDatabase() {
        $insertValues = array($this->getId(),
            $this->getName(),
            $this->getAgeYears(),
            $this->getSex(),
            $this->getSize());

        return SQLite::insertInto(self::TABLE, self::TABLECOLUMNS, $insertValues);
    }

    public function updatePlatypus($updateValues, $where) {

        return SQLite::update(self::TABLE, self::TABLECOLUMNS, $updateValues, $where);
    }

    public function deletePlatypus() {

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