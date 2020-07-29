<?php
namespace Model\DAO;

use Hydro\Base\Contracts\ResetTokenDAOInterface;
use PDOException;

class ResetTokenDAO implements ResetTokenDAOInterface
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

    public function deleteExpired() {
        $sql = "DELETE FROM reset_tokens WHERE expiration_date < date('now');";

        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('ResetTokenDAO deleteExpired error');
        }
    }

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