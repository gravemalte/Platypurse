<?php

namespace Model;

use Model\DAO\SavedOffersDAO;

class SavedOfferModel {
    private $id;
    private $userId;
    private $offerId;
    private $active;

    /**
     * SavedOfferModel constructor.
     * @param $id
     * @param $userId
     * @param $offerId
     * @param $active
     */
    public function __construct($id, $userId, $offerId, $active)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->offerId = $offerId;
        $this->active = $active;
    }

    /**
     * Insert model into database
     * @param SavedOffersDAO $savedOffersDAO
     * @return mixed
     */
    public function insertIntoDatabase($savedOffersDAO) {
        return $savedOffersDAO->create($this);
    }

    /**
     * Returns models by user id from database
     * @param SavedOffersDAO $savedOffersDAO
     * @param $userId
     * @return array
     */
    public static function getFromDatabaseByUserId($savedOffersDAO, $userId) {
        $result = $savedOffersDAO->readByUserId($userId);

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new SavedOfferModel($row[0], $row[1], $row[2], $row[3]);
        endforeach;

        return $returnArray;
    }

    /**
     * Returns model by user id and offer id from database
     * @param SavedOffersDAO $savedOffersDAO
     * @param $userId
     * @param $offerId
     * @param $onlyActives
     * @return false|SavedOfferModel
     */
    public static function getFromDatabaseByUserIdAndOfferId($savedOffersDAO, $userId, $offerId, $onlyActives) {
        $result = $savedOffersDAO->readByUserIdAndOfferId($userId, $offerId, $onlyActives);

        if(empty($result)):
            return false;
        endif;

        return new SavedOfferModel($result[0], $result[1], $result[2], $result[3]);
    }

    /**
     * Update model in database
     * @param SavedOffersDAO $dao
     * @return mixed
     */
    public function updateInDatabase($dao) {
        return $dao->update($this);
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
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * @param mixed $offerId
     */
    public function setOfferId($offerId): void
    {
        $this->offerId = $offerId;
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
    public function setActive($active): void
    {
        $this->active = $active;
    }
}