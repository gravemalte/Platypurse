<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;
use PDO;

class HotOfferModel extends BaseModel {

    private $o_id;
    private $name;
    private $price;
    private $negotiable;
    private $description;
    private $sex;
    private $ageYears;
    private $size;
    private $clicks;

    /**
     * OfferGridModel constructor.
     * @param $o_id
     * @param $name
     * @param $price
     * @param $negotiable
     * @param $description
     * @param $sex
     * @param $ageYears
     * @param $size
     * @param $clicks
     */
    public function __construct($o_id, $name, $price, $negotiable, $description, $sex, $ageYears, $size, $clicks)
    {
        $this->o_id = $o_id;
        $this->name = $name;
        $this->price = number_format($price/100, 2, ',', '.');
        $this->negotiable = $negotiable;
        $this->description = $description;
        $this->sex = $sex;
        $this->ageYears = $ageYears;
        $this->size = $size;
        $this->clicks = $clicks;
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getOId()
    {
        return $this->o_id;
    }

    /**
     * @param mixed $o_id
     */
    public function setOId($o_id): void
    {
        $this->o_id = $o_id;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getNegotiable()
    {
        return $this->negotiable;
    }

    /**
     * @param mixed $negotiable
     */
    public function setNegotiable($negotiable): void
    {
        $this->negotiable = $negotiable;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
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
    public function getAgeYears()
    {
        return $this->ageYears;
    }

    /**
     * @param mixed $ageYears
     */
    public function setAgeYears($ageYears): void
    {
        $this->ageYears = $ageYears;
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
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * @param mixed $clicks
     */
    public function setClicks($clicks): void
    {
        $this->clicks = $clicks;
    }
}