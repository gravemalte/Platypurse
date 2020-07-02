<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use PDOException;

class UserRatingModel extends BaseModel {
    private $id;
    private $fromUserId;
    private $forUserId;
    private $rating;

    /**
     * UserRatingModel constructor.
     * @param $id
     * @param $fromUserId
     * @param $forUserId
     * @param $rating
     */
    public function __construct($id, $fromUserId, $forUserId, $rating)
    {
        $this->id = $id;
        $this->fromUserId = $fromUserId;
        $this->forUserId = $forUserId;
        $this->rating = $rating;
    }

    public function insertIntoDatabase($dao) {
        return $dao->create($this);
    }

    public static function getFromDatabaseByFromUserIdAndForUserId($dao, $fromUserId, $forUserId) {
        $result = $dao->readFromUserIdForUserId($fromUserId, $forUserId);
        return new UserRatingModel($result[0], $result[1], $result[2], $result[3]);
    }

    public static function getRatingFromDatabaseForUserId($dao, $userId) {
        return $dao->readForUserId($userId)[0];
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
    public function getFromUserId()
    {
        return $this->fromUserId;
    }

    /**
     * @param mixed $fromUserId
     */
    public function setFromUserId($fromUserId): void
    {
        $this->fromUserId = $fromUserId;
    }

    /**
     * @return mixed
     */
    public function getForUserId()
    {
        return $this->forUserId;
    }

    /**
     * @param mixed $forUserId
     */
    public function setForUserId($forUserId): void
    {
        $this->forUserId = $forUserId;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating): void
    {
        $this->rating = $rating;
    }
}