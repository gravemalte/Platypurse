<?php
namespace Model\DAO;

use Hydro\Base\Contracts\ResetTokenDAOInterface;
use Model\ResetTokenModel;
use PDOException;

class ResetTokenDAO implements ResetTokenDAOInterface
{
    private $con;

    /**
     * ResetTokenDAO constructor.
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
     * @param ResetTokenModel $obj
     * @return mixed
     */
    public function create($obj)
    {
        $query = "INSERT INTO reset_tokens (token_id, token, u_id, expiration_date) 
            VALUES (:id, :token, :userId, :expirationDate);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $obj->getId());
        $stmt->bindValue(":token", $obj->getToken());
        $stmt->bindValue(":userId", $obj->getUser()->getId());
        $stmt->bindValue(":expirationDate", $obj->getExpirationDate());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM reset_tokens WHERE token_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            throw new PDOException('ResetTokenDAO create error');
        }
    }

    /**
     * Read entry by token from Database
     * @param $token
     * @return mixed
     */
    public function read($token)
    {
        $sql = "SELECT * FROM reset_tokens
                    WHERE token = :token;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":token", $token);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('ResetTokenDAO read error');
        }
    }

    /**
     * Updates model in database
     * @param ResetTokenModel $obj
     * @return bool
     */
    public function update($obj)
    {
        $sql = "UPDATE reset_tokens SET token = :token, expiration_date = :date WHERE token_id = :id;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":token", $obj->getToken());
        $stmt->bindValue(":date", $obj->getExpirationDate());
        $stmt->bindValue(":id", $obj->getId());


        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('ResetTokenDAO update error');
        }
    }

    /**
     * Delete expired entries from database
     * @return bool
     */
    public function deleteExpired() {
        $sql = "DELETE FROM reset_tokens WHERE expiration_date < date('now');";

        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('ResetTokenDAO deleteExpired error');
        }
    }

    /**
     * Update entry in database
     * @param $id
     * @return bool
     */
    public function deleteForUser($id) {
        $sql = "DELETE FROM reset_tokens WHERE u_id = :userId;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":userId", $id);

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('ResetTokenDAO deleteForUser error');
        }
    }
}