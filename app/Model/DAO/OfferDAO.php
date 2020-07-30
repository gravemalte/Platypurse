<?php
namespace Model\DAO;

use Hydro\Base\Contracts\OfferDAOInterface;
use Model\OfferModel;
use PDOException;

class OfferDAO implements OfferDAOInterface
{
    private $con;

    /**
     * OfferDAO constructor.
     * @param $con
     */
    public function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * Returns the current connection
     * @return mixed
     */
    public function getCon() {
        return $this->con;
    }

    /**
     * Insert entry into database
     * @param OfferModel $obj
     * @return mixed
     */
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
            throw new PDOException('OfferDAO create error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read entry by id from database
     * @param $id
     * @return mixed
     */
    public function read($id) {
        $query = "SELECT * FROM offer WHERE o_id = :id;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('OfferDAO read error ' . $stmt->errorInfo());
        }
    }

    /**
     * Update entry in database
     * @param OfferModel $obj
     * @return bool
     */
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
            throw new PDOException('OfferDAO update error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read top entry from database, based on descending order by clicks
     * @return mixed
     */
    public function readHot()
    {
        $sql = "SELECT * FROM offer 
            INNER JOIN user on offer.u_id = user.u_id
            WHERE active = 1 AND user.disabled = 0
            ORDER BY clicks desc LIMIT 1;";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('OfferDAO readAll error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read top 9 entrys from database, based on descending order by create date
     * @return mixed
     */
    public function readNewest()
    {
        $sql = "SELECT * FROM offer
            INNER JOIN user on offer.u_id = user.u_id
            WHERE active = 1 AND user.disabled = 0
            ORDER BY create_date desc LIMIT 9;";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferDAO readAll error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read entries for user id from database, based on entries in saved_offers table
     * @param $userId
     * @return mixed
     */
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
            throw new PDOException('OfferDAO readByUserId error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read entries by user id from database
     * @param $userId
     * @return mixed
     */
    public function readOffersByUserId($userId)
    {
        $sql = "SELECT * FROM offer WHERE u_id = :userId;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":userId", $userId);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('OfferDAO readOffersByUserId error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read entries by search filters from database
     * @param $getCount
     * @param $keyedSearchValuesArray
     * @return mixed
     */
    public function readSearchResults($getCount, $keyedSearchValuesArray)
    {
        $bindSex = array_key_exists("sex", $keyedSearchValuesArray);
        $sql = "SELECT ";
        if($getCount):
            $sql .= "COUNT(*) as test";
        else:
            $sql .= "*";
        endif;
        $sql .= " FROM offer INNER JOIN platypus ON platypus.p_id = offer.p_id
            INNER JOIN user on offer.u_id = user.u_id
            WHERE (name LIKE :name
            OR description LIKE :description)
            AND age_years BETWEEN :ageMin and :ageMax 
            AND size BETWEEN :sizeMin and :sizeMax 
            AND weight BETWEEN :weightMin and :weightMax
            AND offer.active = 1
            AND user.disabled = 0";

        if($bindSex):
            $sql .= " AND sex = :sex";
        endif;

        if(!$getCount):
            $sql .= " LIMIT :limit OFFSET :offset";
        endif;

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":name", $keyedSearchValuesArray['name']);
        $stmt->bindValue(":description", $keyedSearchValuesArray['description']);
        $stmt->bindValue(":ageMin", $keyedSearchValuesArray['ageMin']);
        $stmt->bindValue(":ageMax", $keyedSearchValuesArray['ageMax']);
        $stmt->bindValue(":sizeMin", $keyedSearchValuesArray['sizeMin']);
        $stmt->bindValue(":sizeMax", $keyedSearchValuesArray['sizeMax']);
        $stmt->bindValue(":weightMin", $keyedSearchValuesArray['weightMin']);
        $stmt->bindValue(":weightMax", $keyedSearchValuesArray['weightMax']);

        if(!$getCount):
            $stmt->bindValue(":limit", $keyedSearchValuesArray['limit']);
            $stmt->bindValue(":offset", $keyedSearchValuesArray['offset']);
        endif;
        if($bindSex):
            $stmt->bindValue(":sex", $keyedSearchValuesArray['sex']);
        endif;

        if($stmt->execute()) {
            if($getCount):
                return $stmt->fetch()['test'];
            else:
                return $stmt->fetchAll();
            endif;
        } else {
            print "error2";
            throw new PDOException('OfferDAO readSearchResults error ' . $stmt->errorInfo());
        }
    }
}