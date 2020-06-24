<?php

namespace Model;

use PDOException;
use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;

class OfferModel extends BaseModel {
    private $id;
    private $user;
    private $platypus;
    private $price;
    private $negotiable;
    private $description;
    private $pictures;
    private $clicks;
    private $create_date;
    private $edit_date;
    private $active;

    /**
     * OfferModel constructor.
     * @param $id
     * @param $user
     * @param $platypus
     * @param $price
     * @param $negotiable
     * @param $description
     * @param $pictures
     * @param $clicks
     * @param $create_date
     * @param $edit_date
     * @param $active
     */
    public function __construct($id, $user, $platypus, $price, $negotiable, $description, $pictures, $clicks = 0, $create_date = "", $edit_date = "", $active = 1)
    {
        if(empty($create_date)):
            $create_date = Date::now();
        endif;

        $this->id = $id;
        $this->user = $user;
        $this->platypus = $platypus;
        $this->price = $price;
        $this->negotiable = $negotiable;
        $this->description = $description;
        $this->pictures = $pictures;
        $this->clicks = $clicks;
        $this->create_date = $create_date;
        $this->edit_date = $edit_date;
        $this->active = $active;
        parent::__construct(TABLE_OFFER, COLUMNS_OFFER);
    }

    public function insertIntoDatabase($con) {
        $result = false;
        if($this->getPlatypus()->insertIntoDatabase($con)):
            if($this->create($con)):
                $result = $this->insertImagesIntoDatabase($con);
            else:
                throw new PDOException();
            endif;
        else:
            throw new PDOException();
        endif;
        return $result;
    }

    public static function getFromDatabase($con, $whereClause, $values) {
        $result = parent::read($con, TABLE_OFFER. " " .$whereClause, $values);
        $offer = array();
        foreach ($result as $row):
            $offer[] = new OfferModel($row[COLUMNS_OFFER["o_id"]],
                UserModel::getFromDatabase($con, "WHERE " .COLUMNS_USER['u_id']. " = ?", array($row[COLUMNS_OFFER["u_id"]])),
                PlatypusModel::getFromDatabase($con, "WHERE " .COLUMNS_PLATYPUS['p_id']. " = ?", array($row[COLUMNS_OFFER["p_id"]])),
                $row[COLUMNS_OFFER["price"]],
                $row[COLUMNS_OFFER["negotiable"]],
                $row[COLUMNS_OFFER["description"]],
                OfferModel::getImagesFromDatabase($con, $row[COLUMNS_OFFER['o_id']]),
                $row[COLUMNS_OFFER["clicks"]],
                $row[COLUMNS_OFFER["create_date"]],
                $row[COLUMNS_OFFER["edit_date"]],
                $row[COLUMNS_OFFER["active"]]);
        endforeach;

        return $offer;
    }

    public function updateInDatabase($con, $editDate = true) {
        $result = false;

        if($editDate):
            $this->setEditDate(Date::now());
        endif;

        try {
            if($this->getPlatypus()->updateInDatabase($con)):
                $updateValues = $this->getDatabaseValues();
                $updateValues[] = $this->getId();
                $result = $this->update($con, $updateValues);
            else:
                throw new PDOException();
            endif;
        }
        catch (PDOException $ex) {
            $result = false;
        }
        finally {
            return $result;
        }
    }

    /**
     * Set active to 0 and update database
     */
    public function deactivateInDatabase() {
        $this->setActive(0);
        $this->setEditDate(Date::now());
        $this->getPlatypus()->setActive(0);
        $this->updateInDatabase(SQLite::connectToSQLite(), false);
    }

    public function insertImagesIntoDatabase($con) {
        if(!empty($this->getPictures())):
            $statement = "INSERT INTO " .TABLE_OFFER_IMAGES. "(";
            foreach (COLUMNS_OFFER_IMAGES as $col):
                $statement .= $col .", ";
            endforeach;
            $statement = substr($statement, 0, -2) .") VALUES ";
            $valueArray = array();
            foreach ($this->getPictures() as $key => $value):
                $statement .= "(?, ?, ?, ?), ";
                $valueArray[] = hexdec(uniqid());
                $valueArray[] = $this->getId();
                $valueArray[] = $key;
                $valueArray[] = $value;
            endforeach;
            $statement = substr($statement, 0, -2) .";";

            //print($statement);
            //print_r($valueArray);

            $command = $con->prepare($statement);
            return $command->execute($valueArray);
        else:
            return true;
        endif;
    }

    public static function getImagesFromDatabase($con, $id) {
        $picturesArray = array();

        $statement = "SELECT * FROM " .TABLE_OFFER_IMAGES. " WHERE " .COLUMNS_OFFER_IMAGES['o_id']. " = ? 
            ORDER BY " .COLUMNS_OFFER_IMAGES['picture_position']. " desc;";

        $command = $con->prepare($statement);
        $command->execute(array($id));

        foreach ($command->fetchAll() as $row):
            $picturesArray[$row[COLUMNS_OFFER_IMAGES['picture_position']]] = $row[COLUMNS_OFFER_IMAGES['image']];
        endforeach;

        return $picturesArray;
    }

    public static function getNewestOffers() {
        $con = SQLite::connectToSQLite();
        $whereClause = "WHERE " .COLUMNS_OFFER['active']. " = ? ORDER BY "
            .COLUMNS_OFFER['create_date']. " desc LIMIT 9";

        return OfferModel::getFromDatabase($con, $whereClause, array(1));
    }

    public static function getHotOffer() {
        $con = SQLite::connectToSQLite();
        $whereClause = "WHERE " .COLUMNS_OFFER['active']. " = ? ORDER BY "
            .COLUMNS_OFFER['clicks']. " desc LIMIT 1";

        return OfferModel::getFromDatabase($con, $whereClause, array(1))[0];
    }

    /**
     *
     */
    public function offerClickPlusOne() {
        $this->setClicks($this->getClicks() + 1);
        $this->updateInDatabase(SQLite::connectToSQLite(), false);
    }

    /**
     * @return array
     */
    public function getDatabaseValues() {
        return array($this->getId(),
            $this->getUser()->getId(),
            $this->getPlatypus()->getId(),
            $this->getPriceUnformatted(),
            $this->getNegotiable(),
            $this->getDescription(),
            $this->getClicks(),
            $this->getCreateDate(),
            $this->getEditDate(),
            $this->isActive());
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
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
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
    public function setPlatypus($platypus)
    {
        $this->platypus = $platypus;
    }

    /**
     * @param bool $sepThousands
     * @return string
     */
    public function getPrice($sepThousands = "")
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
    public function setPrice($price)
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
    public function setNegotiable($negotiable)
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
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @param mixed $pictures
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
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
    public function setClicks($clicks)
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
    public function setCreateDate($create_date)
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
    public function setEditDate($edit_date)
    {
        $this->edit_date = $edit_date;
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