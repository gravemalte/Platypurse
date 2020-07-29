<?php
namespace Model\DAO;

use Hydro\Base\Contracts\OfferImagesDAOInterface;
use Model\OfferImageModel;
use PDOException;

class OfferImageDAO implements OfferImagesDAOInterface
{
    private $con;

    /**
     * OfferImageDAO constructor.
     * @param $con
     */
    public function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * Insert entry into database
     * @param OfferImageModel $obj
     * @return mixed
     */
    public function create($obj)
    {
        $query = "INSERT INTO offer_images (oi_id, o_id, picture_position, mime, image) 
            VALUES (:offerImagesId, :offerId, :picturePosition, :mime, :image);";
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
            throw new PDOException('OfferImageDAO create error');
        }

    }

    /**
     * Read entry by offer id from database
     * @param $offerId
     * @return mixed
     */
    public function readByOfferId($offerId)
    {
        $query = "SELECT * FROM offer_images WHERE o_id = :offerId;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":offerId", $offerId);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('OfferImageDAO select by offerId error');
        }
    }

    /**
     * Update entry in database
     * @param OfferImageModel $obj
     * @return bool
     */
    public function update($obj)
    {
        $sql = "UPDATE offer_images SET picture_position = :picturePosition, mime = :mime, image = :image
                WHERE o_id = :id;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":picturePosition", $obj->getPicturePosition());
        $stmt->bindValue(":mime", $obj->getMime());
        $stmt->bindValue(":image", $obj->getImage());
        $stmt->bindValue(":id", $obj->getOfferId());

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('OfferImageDAO update error');
        }
    }
}