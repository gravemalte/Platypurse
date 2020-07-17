<?php
namespace Model\DAO;

use Hydro\Base\Contracts\UserRatingDAOInterface;
use PDOException;

class UserRatingDAO implements UserRatingDAOInterface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $query = "INSERT INTO user_rating(ur_id, from_u_id, for_u_id, rating)
            VALUES (:userRatingId, :fromUserId, :forUserId, :rating);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":userRatingId", $obj->getId());
        $stmt->bindValue(":fromUserId", $obj->getFromUserId());
        $stmt->bindValue(":forUserId", $obj->getForUserId());
        $stmt->bindValue(":rating", $obj->getRating()());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM user_rating WHERE ur_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            return new PDOException('UserRatingDAO create error');
        }

    }

    public function readForUserId($forUserId)
    {
        $query = "SELECT AVG(rating) FROM user_rating WHERE for_u_id = :forUserId;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":forUserId", $forUserId);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('UserRatingDAO readForUserId error');
        }
    }

    public function readFromUserIdForUserId($fromUserId, $forUserId)
    {
        $query = "SELECT * FROM user_rating
            WHERE from_u_id = :fromUserId
            AND for_u_id = :forUserId;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":fromUserId", $fromUserId);
        $stmt->bindValue(":forUserId", $forUserId);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('UserRatingDAO readForUserId error');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE user_rating SET for_u_id = :forUserId, rating = :rating
            WHERE ur_id = :id;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":forUserId", $obj->getForUserId());
        $stmt->bindValue(":rating", $obj->getRating());
        $stmt->bindValue(":id", $obj->getId());

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('UserRatingDAO update error');
        }
    }
}