<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;

class OfferModel extends BaseModel {
    const TABLE = "offer";
    const TABLECOLUMNS = array("o_id" => "o_id",
        "u_id" => "u_id",
        "p_id" => "p_id",
        "price" => "price",
        "negotiable" => "negotiable",
        "description" => "description",
        "clicks" => "clicks",
        "create_date" => "create_date",
        "edit_date" => "edit_date",
        "active" => "active");

    private $id;
    private $userId;
    private $platypus;
    private $price;
    private $negotiable;
    private $description;
    private $clicks;
    private $create_date;
    private $edit_date;
    private $active;

    /**
     * OfferModel constructor.
     * @param $id
     * @param $userId
     * @param $platypus
     * @param $price
     * @param $negotiable
     * @param $description
     * @param $clicks
     * @param $create_date
     * @param $edit_date
     * @param $active
     */
    public function __construct($id, $userId, $platypus, $price, $negotiable, $description, $clicks = 0, $create_date = "", $edit_date = "", $active = 1)
    {
        if(empty($create_date)):
            $create_date = Date::now();
        endif;

        $this->id = $id;
        $this->userId = $userId;
        $this->platypus = $platypus;
        $this->price = $price;
        $this->negotiable = $negotiable;
        $this->description = $description;
        $this->clicks = $clicks;
        $this->create_date = $create_date;
        $this->edit_date = $edit_date;
        $this->active = $active;
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
            $offer[] = new OfferModel($row[self::TABLECOLUMNS["o_id"]],
                $row[self::TABLECOLUMNS["u_id"]],
                PlatypusModel::getFromDatabase(OfferModel::TABLECOLUMNS["p_id"]. " = ? ",
                    array($row[OfferModel::TABLECOLUMNS["p_id"]])),
                $row[self::TABLECOLUMNS["price"]],
                $row[self::TABLECOLUMNS["negotiable"]],
                $row[self::TABLECOLUMNS["description"]],
                $row[self::TABLECOLUMNS["clicks"]],
                $row[self::TABLECOLUMNS["create_date"]],
                $row[self::TABLECOLUMNS["edit_date"]],
                $row[self::TABLECOLUMNS["active"]]);
        endforeach;

        if(sizeof($offer) <= 1):
            return array_shift($offer);
        else:
            return $offer;
        endif;
    }

    public function writeToDatabase() {
        // Check if offer exists in database
        $offerInDatabase = $this->getFromDatabase(self::TABLECOLUMNS["o_id"]. " = ?"
        , array($this->getId()));

        // If platypus doesn't exist, insert into database. Else update in database
        if(empty($offerInDatabase)):
            $this->insertIntoDatabase();
        else:
            $this->updateInDatabase();
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

        $preparedWhereClause = self::TABLECOLUMNS["o_id"]. " = " .$this->getId();

        return SQLite::updateBuilder(self::TABLE,
            substr($preparedSetClause, 0, -1),
            $preparedWhereClause,
            $this->getDatabaseValues());
    }

    /**
     *
     */
    public function offerClickPlusOne() {
        $this->setClicks($this->getClicks() + 1);
        $this->updateInDatabase();
    }

    /**
     *
     */
    public function deleteFromDatabase() {
        return SQLite::deleteBuilder(self::TABLE,
            self::TABLECOLUMNS['o_id']. " = ?;",
            array($this->getId()));
    }

    /**
     * @return array
     */
    public function getDatabaseValues() {
        return array($this->getId(),
            $this->getUserId(),
            $this->getPlatypus()->getId(),
            $this->getPriceUnformatted(),
            $this->getNegotiable(),
            $this->getDescription(),
            $this->getClicks(),
            $this->getCreateDate(),
            $this->getEditDate(),
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
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return UserModel::searchUser($this->userId);
    }

    /**
     * @return mixed
     */
    public function getPlatypus()
    {
        return $this->platypus;
    }

    /**
     * @param mixed $platypus
     */
    public function setPlatypus($platypus): void
    {
        $this->platypus = $platypus;
    }

    /**
     * @param bool $sepThousands
     * @return string
     */
    public function getPrice(bool $sepThousands)
    {
        $thousandSep = "";
        if($sepThousands):
            $thousandSep = ".";
        endif;
        return number_format($this->price/100, 2, ',', $thousandSep);
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
    public function getPriceUnformatted()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getShortPrice()
    {
        $price = $this->getPrice(true);
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

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param mixed $create_date
     */
    public function setCreateDate($create_date): void
    {
        $this->create_date = $create_date;
    }

    /**
     * @return mixed
     */
    public function getEditDate()
    {
        return $this->edit_date;
    }

    /**
     * @param mixed $edit_date
     */
    public function setEditDate($edit_date): void
    {
        $this->edit_date = $edit_date;
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