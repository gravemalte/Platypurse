<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use PDOException;

class SavedOfferModel extends BaseModel {
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

    public function insertIntoDatabase($savedOffersDAO) {
        return $savedOffersDAO->create($this);
    }

    public static function getFromDatabaseByUserId($savedOffersDAO, $userId) {
        $result = $savedOffersDAO->readByUserId($userId);

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new SavedOfferModel($row[0], $row[1], $row[2], $row[3]);
        endforeach;

        return $returnArray;
    }

    public static function getFromDatabaseByUserIdAndOfferId($savedOffersDAO, $userId, $offerId, $withActives) {
        $result = $savedOffersDAO->readByUserIdAndOfferId($userId, $offerId, $withActives);

        return new SavedOfferModel($result[0], $result[1], $result[2], $result[3]);
    }
    
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