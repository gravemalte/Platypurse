<?php


namespace Model\DAO;
use PDO;
use PDOException;

use Model\offer_imagesModel;
use Hydro\Base\Contracts\DAOContract;


class DAOOfferImages implements DAOContract
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $this->con->beginTransaction();
        $query = "INSERT INTO offer_images (oi_id, o_id, picture_position, mime, image) 
            VALUES (:offerImagesId, :offerId, :picturePosition, :mime, :image)";
        $stmt = $this->con->prepare($query);
        // TODO: Object for offer images?
        $stmt->bindValue(":offerImagesId", $obj->getId());
        $stmt->bindValue(":offerId", $obj->getUser()->getId());
        $stmt->bindValue(":mime", $obj->getPlatypus()->getId());
        $stmt->bindValue(":image", $obj->getPrice());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM offer_images WHERE oi_id = $id";
            $result = $this->con->query($sql);
            $this->con->commit();
            return $result->fetch();
        } else {
            $this->con->rollback();
            return new PDOException('DAOOfferImages create error');
        }

    }

    public function read($id)
    {
        $query = "SELECT * FROM offer_images WHERE o_id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('DAOOfferImages read error');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE offer_images SET price = :price, negotiable = :negotiable, description = :description,
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
            throw new PDOException('DAOOfferImages update error');
        }
    }

    public function delete($id)
    {
    }

    public function readAll()
    {
        $sql = "SELECT * FROM offer_images";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('DAOOfferImages readAll error');
        }
    }
}