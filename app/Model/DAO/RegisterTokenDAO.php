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
        $query = "INSERT INTO register_tokens (token_id, token, u_id, expiration_date, active) 
            VALUES (:id, :token, :userId, :expirationDate, :active);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $obj->getId());
        $stmt->bindValue(":token", $obj->getToken());
        $stmt->bindValue(":userId", $obj->getUser()->getId());
        $stmt->bindValue(":expirationDate", $obj->getExpirationDate());
        $stmt->bindValue(":active", $obj->isActive());

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

    public function update($obj)
    {
        $sql = "UPDATE register_tokens SET active = :active WHERE token_id = :id;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":active", $obj->isActive());
        $stmt->bindValue(":id", $obj->getId());


        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('RegisterTokenDAO update error');
        }
    }
}