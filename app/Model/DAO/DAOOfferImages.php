<?php
namespace Model\DAO;

use PDOException;
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
        $query = "INSERT INTO offer_images (oi_id, o_id, picture_position, mime, image) 
            VALUES (:offerImagesId, :offerId, :picturePosition, :mime, :image)";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":offerImagesId", $obj->getId());
        $stmt->bindValue(":offerId", $obj->getOfferId());
        $stmt->bindValue(":picturePosition", $obj->getPicturePosition());
        $stmt->bindValue(":mime", $obj->getMime());
        $stmt->bindValue(":image", $obj->getImage());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM offer_images WHERE oi_id = $id";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
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
        // TODO: Where oi_id
        $sql = "UPDATE offer_images SET picture_position = :picturePosition, mime = :mime, image = :image
                WHERE o_id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":picturePosition", $obj->getPicturePosition());
        $stmt->bindValue(":mime", $obj->getMime());
        $stmt->bindValue(":image", $obj->getImage());
        $stmt->bindValue(":id", $obj->getOfferId());

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('DAOOfferImages update error');
        }
    }

    public function delete($id)
    {
    }

    public function readByOfferId($offerId)
    {
        $query = "SELECT * FROM offer_images WHERE o_id = :offerId";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":offerId", $offerId);

        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            throw new PDOException('DAOOfferImages select by offerId error');
        }
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