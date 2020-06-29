<?php


namespace Model\DAO;
use PDO;
use PDOException;

use Model\OfferModel;
use Hydro\Base\Contracts\DAOContract;


class DAOOffer implements DAOContract
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $this->con->beginTransaction();
        $query = "INSERT INTO offer (o_id, u_id, p_id, price, negotiable, description) 
            VALUES (:offerId, :userId, :platypusId, :price, :negotiable, :description)";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":offerId", $obj->getId());
        $stmt->bindValue(":userId", $obj->getUser()->getId());
        $stmt->bindValue(":platypusId", $obj->getPlatypus()->getId());
        $stmt->bindValue(":price", $obj->getPrice());
        $stmt->bindValue(":negotiable", $obj->getNegotiable());
        $stmt->bindValue(":description", $obj->getDescription());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM offer WHERE o_id = $id";
            $result = $this->con->query($sql);
            $this->con->commit();
            return $result->fetch();
        } else {
            $this->con->rollback();
            return new PDOException('DAOOffer create error');
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
            throw new PDOException('DAOOffer read error');
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
            throw new PDOException('DAOOffer update error');
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
            throw new PDOException('DAOOffer readAll error');
        }
    }
}