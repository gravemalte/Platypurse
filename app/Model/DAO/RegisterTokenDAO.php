<?php
namespace Model\DAO;

use Hydro\Base\Contracts\RegisterTokenDAOInterface;
use PDOException;

class RegisterTokenDAO implements RegisterTokenDAOInterface
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
        $query = "INSERT INTO register_tokens (token_id, token, u_id, expiration_date) 
            VALUES (:id, :token, :userId, :expirationDate);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $obj->getId());
        $stmt->bindValue(":token", $obj->getToken());
        $stmt->bindValue(":userId", $obj->getUser()->getId());
        $stmt->bindValue(":expirationDate", $obj->getExpirationDate());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM register_tokens WHERE token_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            return new PDOException('RegisterTokenDAO create error');
        }
    }

    public function read($id)
    {
        $sql = "SELECT * FROM register_tokens
                    WHERE token_id = :id;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('RegisterTokenDAO read error');
        }
    }

    public function deleteExpired() {
        $sql = "DELETE FROM register_tokens WHERE expiration_date < date('now');";

        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('RegisterTokenDAO deleteExpired error');
        }
    }

    public function deleteForUser($id) {
        $sql = "DELETE FROM register_tokens WHERE u_id = :userId;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":userId", $id);

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('RegisterTokenDAO deleteForUser error');
        }
    }
}