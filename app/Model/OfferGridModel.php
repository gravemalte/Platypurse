<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use PDO;

class OfferGridModel extends BaseModel {
    const TABLE = TABLE_OFFER." INNER JOIN " .TABLE_PLATYPUS. " ON "
        .TABLE_OFFER. "." .COLUMNS_OFFER["p_id"]. " = "
        .TABLE_PLATYPUS. "." .COLUMNS_PLATYPUS["p_id"];

    const TABLEJOINSAVEDOFFERS = self::TABLE. " INNER JOIN " .TABLE_SAVED_OFFERS. " ON "
        .TABLE_OFFER. "." .COLUMNS_OFFER["o_id"]. " = "
        .TABLE_SAVED_OFFERS. "." .COLUMNS_SAVED_OFFERS["o_id"];

    const TABLECOLUMNS = array(COLUMNS_OFFER["o_id"] => TABLE_OFFER.".".COLUMNS_OFFER["o_id"],
        COLUMNS_PLATYPUS["name"] => COLUMNS_PLATYPUS["name"],
        COLUMNS_OFFER["price"] => COLUMNS_OFFER["price"],
        COLUMNS_OFFER["negotiable"] => COLUMNS_OFFER["negotiable"],
        COLUMNS_OFFER["description"] => COLUMNS_OFFER["description"]);
    
    private $o_id;
    private $name;
    private $price;
    private $negotiable;
    private $description;

    /**
     * OfferGridModel constructor.
     * @param $o_id
     * @param $name
     * @param $price
     * @param $negotiable
     * @param $description
     */
    public function __construct($o_id, $name, $price, $negotiable, $description)
    {
        $this->o_id = $o_id;
        $this->name = $name;
        $this->price = $price;
        $this->negotiable = $negotiable;
        $this->description = $description;
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


    public static function getFromDatabase($fromClause, $preparedWhereClause = "", $values = array(),
                                           $groupClause = "", $orderClause = "", $limitClause = "") {
        $offer = array();
        $result = SQLite::selectBuilder(self::TABLECOLUMNS,
            $fromClause,
            $preparedWhereClause,
            $values,
            $groupClause,
            $orderClause,
            $limitClause);

        foreach ($result as $row):
            $offer[] = new OfferGridModel($row[COLUMNS_OFFER["o_id"]],
                $row[self::TABLECOLUMNS[COLUMNS_PLATYPUS["name"]]],
                $row[self::TABLECOLUMNS[COLUMNS_OFFER["price"]]],
                $row[self::TABLECOLUMNS[COLUMNS_OFFER["negotiable"]]],
                $row[self::TABLECOLUMNS[COLUMNS_OFFER["description"]]]);
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
    public function getShortPrice()
    {
        $price = $this->getPrice();
        if (substr($price, -2) == "00") {
            return substr($price, 0, strlen($price) - 3);
        }
        return $price;
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
}