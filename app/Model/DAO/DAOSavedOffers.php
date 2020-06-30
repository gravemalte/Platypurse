<?php


namespace Model\DAO;
use PDO;
use PDOException;

use Model\OfferModel;
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
        $this->con->beginTransaction();
        $query = "INSERT INTO saved_offers (u_id, o_id) VALUES (:userId, :offerId)";
        $stmt = $this->con->prepare($query);
        // TODO: Object for saved offers?
        $stmt->bindValue(":userId", $obj->getUser()->getId());
        $stmt->bindValue(":offerId", $obj->getId());

        if($stmt->execute()) {
            $sql = "SELECT * FROM saved_offers WHERE o_id = :offerId AND u_id = :userId";
            $result = $this->con->query($sql);
            $this->con->commit();
            return $result->fetch();
        } else {
            $this->con->rollback();
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
        $sql = "UPDATE offer SET price = :price, negotiable = :negotiable, description = :description,
                 clicks = :clicks, edit_date = :edit_date, active = :active WHERE u_id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":price", $obj->getPrice());
        $stmt->bindValue(":negotiable", $obj->getNegotiable());
        $stmt->bindValue(":description", $obj->getDescription());
        $stmt->bindValue(":clicks", $obj->getClicks());
        $stmt->bindValue(":edit_date", $obj->getEditDate());
        $stmt->bindValue(":active", $obj->getActive());

        if($stmt->execute()) {
            return $stmt->fetch();
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
}