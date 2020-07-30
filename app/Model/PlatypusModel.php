<?php

namespace Model;

use Model\DAO\PlatypusDAO;

class PlatypusModel {
    private $id;
    private $name;
    private $ageYears;
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
        $this->name = htmlspecialchars(strip_tags($name));
        $this->ageYears = htmlspecialchars(strip_tags($age_years));
        $this->sex = htmlspecialchars(strip_tags($sex));
        $this->size = htmlspecialchars(strip_tags($size));
        $this->weight = htmlspecialchars(strip_tags($weight));
        $this->active = $active;
    }

    /**
     * Insert model into database
     * @param PlatypusDAO $dao
     * @return mixed
     */
    public function insertIntoDatabase($dao) {
        return $dao->create($this);
    }

    /**
     * Returns model by id from database
     * @param PlatypusDAO $platypusDAO
     * @param $id
     * @return PlatypusModel
     */
    public static function getFromDatabaseById($platypusDAO, $id){
        $result = $platypusDAO->read($id);

        return new PlatypusModel($result[0], $result[1], $result[2], $result[3], $result[4], $result[5], $result[6]);
    }

    /**
     * Update model in database
     * @param PlatypusDAO $dao
     * @return mixed
     */
    public function updateInDatabase($dao) {
        return $dao->update($this);
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
    public function setId($id)
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
    public function setName($name)
    {
        $this->name = htmlspecialchars(strip_tags($name));
    }

    /**
     * @return mixed
     */
    public function getAgeYears()
    {
        return $this->ageYears;
    }

    /**
     * @param mixed $ageYears
     */
    public function setAgeYears($ageYears)
    {
        $this->ageYears = htmlspecialchars(strip_tags($ageYears));
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
    public function setSex($sex)
    {
        $this->sex = htmlspecialchars(strip_tags($sex));
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
    public function setSize($size)
    {
        $this->size = htmlspecialchars(strip_tags($size));
    }

    /**
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param $weight
     */
    public function setWeight($weight)
    {
        $this->weight = htmlspecialchars(strip_tags($weight));
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }
}