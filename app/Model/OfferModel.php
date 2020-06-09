<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;
use Model\UserModel;

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
        $this->price = number_format($price/100, 2, ',', '.');
        $this->negotiable = $negotiable;
        $this->description = $description;
        $this->clicks = $clicks;
        $this->create_date = $create_date;
        $this->edit_date = $edit_date;
        $this->active = $active;
        parent::__construct();
    }

    public function writeToDatabase() {
        $insertValues = array($this->getId(),
            $this->getUserId(),
            $this->getPlatypus()->getId(),
            str_replace(',', '', $this->getPrice()),
            $this->getNegotiable(),
            $this->getDescription(),
            $this->getClicks(),
            $this->getCreateDate(),
            $this->getEditDate(),
            $this->getActive());

        return SQLite::insertBuilder(self::TABLE, self::TABLECOLUMNS, $insertValues);
    }

    /**
     *
     */
    public function offerClickPlusOne() {
        $preparedSet = OfferModel::TABLECOLUMNS['clicks']." = ?";
        $preparedWhere = OfferModel::TABLECOLUMNS['o_id']." = ?;";
        $values = array(($this->getClicks() + 1), $this->getId());
        SQLite::updateBuilder(OfferModel::TABLE, $preparedSet, $preparedWhere, $values);
    }

    public function deleteOffer() {

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
    public function getShortPrice()
    {
        if (substr($this->price, -2) == "00") {
            return substr($this->price, 0, strlen($this->price) - 3);
        }
        return $this->price;
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