<?php
namespace Model\DAO;

use PDOException;
use Hydro\Base\Contracts\DAOContract;

class DAOSavedOffers implements DAOContract
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $query = "INSERT INTO saved_offers (so_id, u_id, o_id, active) VALUES (:id, :userId, :offerId, :active)";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $obj->getId());
        $stmt->bindValue(":userId", $obj->getUserId());
        $stmt->bindValue(":offerId", $obj->getOfferId());
        $stmt->bindValue(":active", $obj->isActive());

        if($stmt->execute()) {
            $sql = "SELECT * FROM saved_offers WHERE o_id = :offerId AND u_id = :userId";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            return new PDOException('DAOSavedOffer create error');
        }

    }

    public function read($id)
    {
        $query = "SELECT * FROM offer WHERE o_id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('DAOSavedOffer read error');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE saved_offers SET active = :active WHERE u_id = :userId AND o_id = :offerId";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":active", $obj->isActive());
        $stmt->bindValue(":userId", $obj->getUserId());
        $stmt->bindValue(":offerId", $obj->getOfferId());


        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('DAOSavedOffer update error');
        }
    }

    public function delete($id)
    {
    }

    public function readAll()
    {
        $sql = "SELECT * FROM offer";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('DAOSavedOffer readAll error');
        }
    }

    public function readByUserId($userId)
    {
        $sql = "SELECT * FROM offer
                    LEFT JOIN saved_offers so on offer.o_id = so.o_id
                    WHERE so.u_id = :userId";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":userId", $userId);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('DAOSavedOffer readByUserId error');
        }
    }

    public function readByUserIdAndOfferId($userId, $offerId, $withActives)
    {
        $sql = "SELECT * FROM saved_offers
                    WHERE u_id = :userId
                    AND o_id = :offerId ";

        if($withActives):
            $sql .= "AND active = 1";
        endif;

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":userId", $userId);
        $stmt->bindValue(":offerId", $offerId);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('DAOSavedOffer readByUserId error');
        }
    }
}