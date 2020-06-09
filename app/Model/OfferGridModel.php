<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;
use PDO;

class OfferGridModel extends BaseModel {
    const TABLE = OfferModel::TABLE." INNER JOIN " .PlatypusModel::TABLE. " ON "
        .OfferModel::TABLE. "." .OfferModel::TABLECOLUMNS["p_id"]. " = "
        .PlatypusModel::TABLE. "." .PlatypusModel::TABLECOLUMNS["p_id"];
    const TABLECOLUMNS = array(OfferModel::TABLECOLUMNS["o_id"] => OfferModel::TABLECOLUMNS["o_id"],
        PlatypusModel::TABLECOLUMNS["name"] => PlatypusModel::TABLECOLUMNS["name"],
        OfferModel::TABLECOLUMNS["price"] => OfferModel::TABLECOLUMNS["price"],
        OfferModel::TABLECOLUMNS["negotiable"] => OfferModel::TABLECOLUMNS["negotiable"],
        OfferModel::TABLECOLUMNS["description"] => OfferModel::TABLECOLUMNS["description"]);
    
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

    public static function getFromDatabase($preparedWhereClause = "", $values = array(),
                                           $groupClause = "", $orderClause = "", $limitClause = "") {
        $offer = array();
        $result = SQLite::selectBuilder(self::TABLECOLUMNS,
            self::TABLE,
            $preparedWhereClause,
            $values,
            $groupClause,
            $orderClause,
            $limitClause);

        foreach ($result as $row):
            $offer[] = new OfferGridModel($row[OfferModel::TABLECOLUMNS["o_id"]],
                $row[self::TABLECOLUMNS[PlatypusModel::TABLECOLUMNS["name"]]],
                $row[self::TABLECOLUMNS[OfferModel::TABLECOLUMNS["price"]]],
                $row[self::TABLECOLUMNS[OfferModel::TABLECOLUMNS["negotiable"]]],
                $row[self::TABLECOLUMNS[OfferModel::TABLECOLUMNS["description"]]]);
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
}