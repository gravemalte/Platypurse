<?php

namespace Model;

use Model\DAO\DAOOfferImages;
use Model\DAO\DAOUser;
use Model\DAO\DAOPlatypus;
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
    private $images;
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
     * @param $images
     * @param $active
     */
    public function __construct($id, $user, $platypus, $price, $negotiable, $description,
                                $clicks, $create_date, $edit_date, $images, $active = 1)
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
        $this->images = $images;
        $this->active = $active;
    }

    public function insertIntoDatabase($offerDAO) {
        return $offerDAO->create($this);
    }

    public static function getFromDatabase($offerDAO, $id){
        $result = $offerDAO->read($id);
        return self::getOfferFromRow($result, $offerDAO);
    }

    public static function getFromDatabaseByUserId($offerDAO, $userId){
        $result = $offerDAO->readOffersByUserId($userId);
        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = self::getOfferFromRow($row, $offerDAO);
        endforeach;

        return $returnArray;
    }

    public static function getSavedOffersFromDatabaseByUserId($offerDAO, $userId){
        $result = $offerDAO->readSavedOffersByUserId($userId);
        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = self::getOfferFromRow($row, $offerDAO);
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
        $result = $offerDAO->readNewest();

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = self::getOfferFromRow($row, $offerDAO);
        endforeach;
        return $returnArray;
    }

    public static function getHotOffer($offerDAO) {
        $result = $offerDAO->readHot();

        return self::getOfferFromRow($result, $offerDAO);
    }

    /**
     *
     */
    public function offerClickPlusOne() {
        $this->setClicks($this->getClicks() + 1);
        $this->updateInDatabase(SQLite::connectToSQLite(), false);
    }

    private static function getOfferFromRow($row, $offerDAO) {
        return new OfferModel($row[0],
            UserModel::getFromDatabaseById(new DAOUser($offerDAO->getCon()), $row[1]),
            PlatypusModel::getFromDatabaseById(new DAOPlatypus($offerDAO->getCon()), $row[2]),
            $row[3], $row[4], $row[5], $row[6], $row[7], $row[8],
            OfferImageModel::getFromDatabaseByOfferId(new DAOOfferImages($offerDAO->getCon()), $row[0]), $row[9]);
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
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    public function getImageOnPosition($pos) {
        $images = $this->getImages();
        if(!empty($images) && count($images) >= $pos):
            $image = $images[$pos];
            return $image->getSrc();
        else:
            return null;
        endif;
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