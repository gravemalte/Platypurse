<?php

namespace Model;

use Model\UserModel;
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
     * @param $clicks
     * @param $create_date
     * @param $edit_date
     * @param $active
     */
    public function __construct($id, $user, $platypus, $price, $negotiable, $description, $clicks = 0, $create_date = "", $edit_date = "", $active = 1)
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
        $this->clicks = $clicks;
        $this->create_date = $create_date;
        $this->edit_date = $edit_date;
        $this->active = $active;
    }

    public function insertIntoDatabase($offerDAO) {
        return $offerDAO->create($this);
    }

    public static function getFromDatabaseByUserId($offerDAO, $userId){
        $result = $offerDAO->readByUserId($userId);

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new OfferModel($row[0],
                UserModel::getFromDatabaseById($offerDAO, $row[1]),
                PlatypusModel::getFromDatabaseById($offerDAO, $row[2]),
                $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
        endforeach;

        return $returnArray;
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

                if($this->update($con, $updateValues)):
                    $picture = $this->getPictures()[0];
                    $updateImageValues = array($picture['mime'], $picture['image'], $this->getId());
                    $result = $this->updateImagesInDatabase($con, $updateImageValues);
                endif;
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
            foreach ($this->getPictures() as $key=>$value):
                $statement .= "(?, ?, ?, ?, ?), ";
                $valueArray[] = hexdec(uniqid());
                $valueArray[] = $this->getId();
                $valueArray[] = $key;
                $valueArray[] = $value[COLUMNS_OFFER_IMAGES['mime']];
                $valueArray[] = $value[COLUMNS_OFFER_IMAGES['image']];
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

    public function updateImagesInDatabase($con, $values) {
        if(!empty($this->getPictures())):
            $statement = "UPDATE " .TABLE_OFFER_IMAGES. " SET mime = ?, image = ? WHERE o_id = ?;";

            //print($statement);
            //print_r($values);

            $command = $con->prepare($statement);
            return $command->execute($values);
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
            $contentArray = array();
            $contentArray[COLUMNS_OFFER_IMAGES['mime']] = $row[COLUMNS_OFFER_IMAGES['mime']];
            $contentArray[COLUMNS_OFFER_IMAGES['image']] = $row[COLUMNS_OFFER_IMAGES['image']];

            $picturesArray[$row[COLUMNS_OFFER_IMAGES['picture_position']]] = $contentArray;
        endforeach;

        return $picturesArray;
    }

    public static function getNewestOffers($offerDAO) {
        $result = $offerDAO->readNew();

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new OfferModel($row[0],
                UserModel::getFromDatabaseById($offerDAO, $row[1]),
                PlatypusModel::getFromDatabaseById($offerDAO, $row[2]),
                $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9]);
        endforeach;

        return $returnArray;
    }

    public static function getHotOffer($offerDAO) {
        $result = $offerDAO->readHot();

        return new OfferModel($result[0],
            UserModel::getFromDatabaseById($offerDAO, $result[1]),
            PlatypusModel::getFromDatabaseById($offerDAO, $result[2]),
            $result[3], $result[4], $result[5], $result[6], $result[7], $result[8], $result[9]);
    }

    /**
     *
     */
    public function offerClickPlusOne() {
        $this->setClicks($this->getClicks() + 1);
        $this->updateInDatabase(SQLite::connectToSQLite(), false);
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

    public function getPictureOnPosition($pos) {
        $pictures = $this->getPictures();
        if(!empty($pictures) && count($pictures) >= $pos):
            $picture = $pictures[$pos];
            return "data:" .$picture[COLUMNS_OFFER_IMAGES['mime']].
                ";base64," .$picture[COLUMNS_OFFER_IMAGES['image']];
        else:
            return null;
        endif;
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