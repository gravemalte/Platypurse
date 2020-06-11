<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;
use PDO;

class HotOfferModel extends BaseModel {
    const TABLE = TABLE_OFFER." INNER JOIN " .TABLE_PLATYPUS. " ON "
        .TABLE_OFFER. "." .COLUMNS_OFFER["p_id"]. " = "
        .TABLE_PLATYPUS. "." .COLUMNS_PLATYPUS["p_id"];
    const TABLECOLUMNS = array(COLUMNS_OFFER["o_id"] => COLUMNS_OFFER["o_id"],
        COLUMNS_PLATYPUS["name"] => COLUMNS_PLATYPUS["name"],
        COLUMNS_OFFER["price"] => COLUMNS_OFFER["price"],
        COLUMNS_OFFER["negotiable"] => COLUMNS_OFFER["negotiable"],
        COLUMNS_OFFER["description"] => COLUMNS_OFFER["description"],
        COLUMNS_PLATYPUS["sex"] => COLUMNS_PLATYPUS["sex"],
        COLUMNS_PLATYPUS["age_years"] => COLUMNS_PLATYPUS["age_years"],
        COLUMNS_PLATYPUS["size"] => COLUMNS_PLATYPUS["size"],
        COLUMNS_PLATYPUS["weight"] => COLUMNS_PLATYPUS["weight"],
        COLUMNS_OFFER["clicks"] => COLUMNS_OFFER["clicks"]);

    private $o_id;
    private $name;
    private $price;
    private $negotiable;
    private $description;
    private $sex;
    private $ageYears;
    private $size;
    private $weight;
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
     * @param $weight
     * @param $clicks
     */
    public function __construct($o_id, $name, $price, $negotiable,
                                $description, $sex, $ageYears, $size, $weight, $clicks)
    {
        $this->o_id = $o_id;
        $this->name = $name;
        $this->price = $price;
        $this->negotiable = $negotiable;
        $this->description = $description;
        $this->sex = $sex;
        $this->ageYears = $ageYears;
        $this->size = $size;
        $this->weight = $weight;
        $this->clicks = $clicks;
        parent::__construct();
    }

    public static function getFromDatabase() {
        $offer = "";
        $result = SQLite::selectBuilder(self::TABLECOLUMNS,
            self::TABLE,
            TABLE_OFFER.".".COLUMNS_OFFER['active']. " = ?",
            array(1),"",
            COLUMNS_OFFER['clicks']. " desc",
            "1");

        foreach ($result as $row):
            $offer = new HotOfferModel($row[self::TABLECOLUMNS[COLUMNS_OFFER["o_id"]]],
                $row[self::TABLECOLUMNS[COLUMNS_PLATYPUS["name"]]],
                $row[self::TABLECOLUMNS[COLUMNS_OFFER["price"]]],
                $row[self::TABLECOLUMNS[COLUMNS_OFFER["negotiable"]]],
                $row[self::TABLECOLUMNS[COLUMNS_OFFER["description"]]],
                $row[self::TABLECOLUMNS[COLUMNS_PLATYPUS["sex"]]],
                $row[self::TABLECOLUMNS[COLUMNS_PLATYPUS["age_years"]]],
                $row[self::TABLECOLUMNS[COLUMNS_PLATYPUS["size"]]],
                $row[self::TABLECOLUMNS[COLUMNS_PLATYPUS["weight"]]],
                $row[self::TABLECOLUMNS[COLUMNS_OFFER["clicks"]]]);
        endforeach;

        return $offer;
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
        return number_format($this->price/100, 2, ',', '.');
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