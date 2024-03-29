<?php

namespace Model;

use Hydro\Helper\Date;
use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\OfferDAO;
use Model\DAO\OfferImageDAO;
use Model\DAO\PlatypusDAO;
use Model\DAO\UserDAO;
use Model\DAO\ZipCoordinatesDAO;
use PDOException;

class OfferModel {
    private $id;
    private $user;
    private $platypus;
    private $price;
    private $negotiable;
    private $description;
    private $zipcode;
    private $clicks;
    private $create_date;
    private $edit_date;
    private $image;
    private $active;

    /**
     * OfferModel constructor.
     * @param $id
     * @param $user
     * @param $platypus
     * @param $price
     * @param $negotiable
     * @param $description
     * @param $zipcode
     * @param $clicks
     * @param $create_date
     * @param $edit_date
     * @param $image
     * @param $active
     */
    public function __construct($id, $user, $platypus, $price, $negotiable, $description,
                                $zipcode, $clicks, $create_date, $edit_date, $image, $active = 1)
    {
        if(empty($create_date)):
            $create_date = Date::now();
        endif;

        $this->id = $id;
        $this->user = $user;
        $this->platypus = $platypus;
        $this->price = htmlspecialchars(strip_tags($price));
        $this->negotiable = $negotiable;
        $this->description = htmlspecialchars(strip_tags($description));
        $this->zipcode = htmlspecialchars(strip_tags($zipcode));
        $this->clicks = $clicks;
        $this->create_date = $create_date;
        $this->edit_date = $edit_date;
        $this->image = $image;
        $this->active = $active;
    }

    /**
     * Insert model into database
     * @param $offerDAO
     * @return bool
     */
    public function insertIntoDatabase($offerDAO) {
        if($this->getPlatypus()->insertIntoDatabase(new PlatypusDAO($offerDAO->getCon()))):
            if($offerDAO->create($this)):
                $check = $this->getImage()->insertIntoDatabase(new OfferImageDAO(($offerDAO->getCon())));
                if(empty($check)):
                    return false;
                endif;
                return true;
            endif;
        endif;
        return false;
    }

    /**
     * Returns model by id from database
     * @param $offerDAO
     * @param $id
     * @return OfferModel|boolean
     */
    public static function getFromDatabase($offerDAO, $id){
        $result = $offerDAO->read($id);
        if(!$result):
            return false;
        endif;
        return self::getOfferFromRow($result, $offerDAO->getCon());
    }

    /**
     * Returns models by search filter from database
     * @param $getCount
     * @param OfferDAO $offerDAO
     * @param $keyedSearchValuesArray
     * @return array
     */
    public static function getSearchResultsFromDatabase($getCount, $offerDAO, $keyedSearchValuesArray) {
        $result = $offerDAO->readSearchResults($getCount, $keyedSearchValuesArray);
        if($getCount):
            return $result;
        else:
            $returnArray = array();
            foreach($result as $row):
                $returnArray[] = self::getOfferFromRow($row, $offerDAO->getCon(), false);
            endforeach;

            return $returnArray;
        endif;
    }

    /**
     * Returns model by user id from database
     * @param $offerDAO
     * @param $userId
     * @return array
     */
    public static function getFromDatabaseByUserId($offerDAO, $userId){
        $result = $offerDAO->readOffersByUserId($userId);
        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = self::getOfferFromRow($row, $offerDAO->getCon(), false);
        endforeach;

        return $returnArray;
    }

    /**
     * Returns models by user id from database, based on saved offers
     * @param $offerDAO
     * @param $userId
     * @return array
     */
    public static function getSavedOffersFromDatabaseByUserId($offerDAO, $userId){
        $result = $offerDAO->readSavedOffersByUserId($userId);
        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = self::getOfferFromRow($row, $offerDAO->getCon(), false);
        endforeach;

        return $returnArray;
    }

    /**
     * Update model in database
     * @param $offerDAO
     * @return bool
     */
    public function updateInDatabase($offerDAO) {
        if($this->getPlatypus()->updateInDatabase(new PlatypusDAO($offerDAO->getCon()))):
            if($offerDAO->update($this)):
                $check = $this->getImage()->updateInDatabase(new OfferImageDAO(($offerDAO->getCon())));
                if(!$check):
                    return false;
                endif;
                return true;
            endif;
        endif;
        return false;
    }

    /**
     * Set active to 0 and update database
     * @param $offerDAO
     * @return bool
     */
    public function deactivateInDatabase($offerDAO) {
        $this->setActive(0);
        $this->setEditDate(Date::now());
        $this->getPlatypus()->setActive(0);
        return $this->updateInDatabase($offerDAO);
    }

    /**
     * Returns top 9 models from database, ordered descending by create date
     * @param $offerDAO
     * @return array
     */
    public static function getNewestOffers($offerDAO) {
        $result = $offerDAO->readNewest();

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = self::getOfferFromRow($row, $offerDAO->getCon(), false);
        endforeach;
        return $returnArray;
    }

    /**
     * Returns top model from database, ordered descending by clicks
     * @param $offerDAO
     * @return OfferModel
     */
    public static function getHotOffer($offerDAO) {
        $result = $offerDAO->readHot();
        return self::getOfferFromRow($result, $offerDAO->getCon(), false);
    }

    /**
     * Add one click to the offer and updates model in database
     * @param $offerDAO
     */
    public function offerClickPlusOne($offerDAO) {
        $this->setClicks($this->getClicks() + 1);
        $this->updateInDatabase($offerDAO);
    }

    /**
     * Returns model from database row
     * @param $row
     * @param $con
     * @param bool $withUser
     * @return OfferModel
     */
    private static function getOfferFromRow($row, $con, $withUser = true) {
        if($withUser):
            $model = new OfferModel($row[0],
                UserModel::getFromDatabaseById(new UserDAO($con), $row[1]),
                PlatypusModel::getFromDatabaseById(new PlatypusDAO($con), $row[2]),
                $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9],
                OfferImageModel::getFromDatabaseByOfferId(new OfferImageDAO($con), $row[0]), $row[10]);
        else:
            $model = new OfferModel($row[0], "",
                PlatypusModel::getFromDatabaseById(new PlatypusDAO($con), $row[2]),
                $row[3], $row[4], $row[5], $row[6], $row[7], $row[8], $row[9],
                OfferImageModel::getFromDatabaseByOfferId(new OfferImageDAO($con), $row[0]), $row[10]);
        endif;
        return $model;
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
        $this->price = htmlspecialchars(strip_tags($price));
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
        if (!$this->isActive()) {
            return "Nicht verfügbar";
        }

        $price = $this->getPrice(true);
        if (substr($price, -2) == "00") {
            return substr($price, 0, strlen($price) - 3);
        }
        return $price;
    }

    /**
     * @return mixed
     */
    public function isNegotiable()
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
        $this->description = htmlspecialchars(strip_tags($description));
    }

    /**
     * @return string
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param string $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = htmlspecialchars(strip_tags($zipcode));
    }

    /**
     * @return ZipCoordinatesModel
     */
    public function getZipCoordinates() {
        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new ZipCoordinatesDAO($con);
            $model = ZipCoordinatesModel::getFromDatabaseByZipcode($dao, $this->zipcode);
            unset($sqlite);
            return $model;

        } catch (PDOException $ex) {
            die(header('location: ' . URL . 'error/databaseError'));
        }
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
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
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