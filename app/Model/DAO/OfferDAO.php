<?php
namespace Model\DAO;

use Hydro\Base\Contracts\OfferDAOInterface;
use PDOException;

class OfferDAO implements OfferDAOInterface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function getCon() {
        return $this->con;
    }

    public function create($obj)
    {
        $query = "INSERT INTO offer (o_id, u_id, p_id, price, negotiable, description, zipcode) 
            VALUES (:offerId, :userId, :platypusId, :price, :negotiable, :description, :zipCode);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":offerId", $obj->getId());
        $stmt->bindValue(":userId", $obj->getUser()->getId());
        $stmt->bindValue(":platypusId", $obj->getPlatypus()->getId());
        $stmt->bindValue(":price", $obj->getPriceUnformatted());
        $stmt->bindValue(":negotiable", $obj->getNegotiable());
        $stmt->bindValue(":description", $obj->getDescription());
        $stmt->bindValue(":zipCode", $obj->getZipcode());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM offer WHERE o_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            return new PDOException('OfferDAO create error');
        }

    }

    public function read($id) {
        $query = "SELECT * FROM offer WHERE o_id = :id;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('OfferDAO read error');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE offer SET price = :price, negotiable = :negotiable, description = :description,
                 zipcode = :zipcode, clicks = :clicks, edit_date = :edit_date, active = :active WHERE o_id = :id;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":price", $obj->getPriceUnformatted());
        $stmt->bindValue(":negotiable", $obj->getNegotiable());
        $stmt->bindValue(":description", $obj->getDescription());
        $stmt->bindValue(":zipcode", $obj->getZipcode());
        $stmt->bindValue(":clicks", $obj->getClicks());
        $stmt->bindValue(":edit_date", $obj->getEditDate());
        $stmt->bindValue(":active", $obj->isActive());
        $stmt->bindValue(":id", $obj->getId());

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('OfferDAO update error');
        }
    }

    public function readHot()
    {
        $sql = "SELECT * FROM offer WHERE active = 1 ORDER BY clicks desc LIMIT 1;";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('OfferDAO readAll error');
        }
    }

    public function readNewest()
    {
        $sql = "SELECT * FROM offer WHERE active = 1 ORDER BY create_date desc LIMIT 9;";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferDAO readAll error');
        }
    }

    public function readSavedOffersByUserId($userId)
    {
        $sql = "SELECT * FROM offer
                    LEFT JOIN saved_offers so on offer.o_id = so.o_id
                    WHERE so.u_id = :userId AND so.active=1;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":userId", $userId);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferDAO readByUserId error');
        }
    }

    public function readOffersByUserId($userId)
    {
        $sql = "SELECT * FROM offer WHERE u_id = :userId;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":userId", $userId);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferDAO readOffersByUserId error');
        }
    }

    public function readSearchResults($keyedSearchValuesArray)
    {
        $bindSex = array_key_exists("sex", $keyedSearchValuesArray);
        // TODO: Add zipcode to query when available
        $sql = "SELECT * FROM offer
                    INNER JOIN platypus ON platypus.p_id = offer.p_id
                    WHERE (name LIKE :name
                      OR description LIKE :description)
                      AND age_years BETWEEN :ageMin and :ageMax 
                      AND size BETWEEN :sizeMin and :sizeMax 
                      AND weight BETWEEN :weightMin and :weightMax
                      AND offer.active = 1";

        if($bindSex):
            $sql .= " AND sex = :sex";
        endif;

        $sql .= " LIMIT :limit OFFSET :offset;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":name", $keyedSearchValuesArray['name']);
        $stmt->bindValue(":description", $keyedSearchValuesArray['description']);
        $stmt->bindValue(":ageMin", $keyedSearchValuesArray['ageMin']);
        $stmt->bindValue(":ageMax", $keyedSearchValuesArray['ageMax']);
        $stmt->bindValue(":sizeMin", $keyedSearchValuesArray['sizeMin']);
        $stmt->bindValue(":sizeMax", $keyedSearchValuesArray['sizeMax']);
        $stmt->bindValue(":weightMin", $keyedSearchValuesArray['weightMin']);
        $stmt->bindValue(":weightMax", $keyedSearchValuesArray['weightMax']);
        $stmt->bindValue(":limit", $keyedSearchValuesArray['limit']);
        $stmt->bindValue(":offset", $keyedSearchValuesArray['offset']);

        if($bindSex):
            $stmt->bindValue(":sex", $keyedSearchValuesArray['sex']);
        endif;

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferDAO readSearchResults error');
        }
    }
}