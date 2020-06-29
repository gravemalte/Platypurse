<?php


namespace Model\DAO;
use http\Client\Curl\User;
use PDO;
use PDOException;

use Model\UserModel;
use Hydro\Base\Contracts\DAOContract;


class DAOUser implements DAOContract
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $this->con->beginTransaction();
        $query = "INSERT INTO user(u_id, display_name, mail, password, ug_id) VALUES (:userID, :displayName, :mail, :password, :ugID)";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":userID", $obj->getId());
        $stmt->bindValue(":displayName", $obj->getDisplayName());
        $stmt->bindValue(":mail", $obj->getMail());
        $stmt->bindValue(":password", $obj->getPassword());
        $stmt->bindValue(":ugID", $obj->getUgId());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM user WHERE u_id = $id";
            $result = $this->con->query($sql);
            $this->con->commit();
            return $result->fetch();
        } else {
            $this->con->rollback();
            return new PDOException('UserModel statement exception');
        }

    }

    public function read($id)
    {
        $query = "SELECT * FROM user WHERE u_id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('UserModel select error...');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE user SET display_name = :displayName, mail = :mail, password = :password, ug_id = :ugId,
                rating = :rating, mime = :mime, image = :image, disabled = :disabled WHERE u_id = :id";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":displayName", $obj->getDisplayName());
        $stmt->bindValue(":mail", $obj->getMail());
        $stmt->bindValue(":password", $obj->getPassword());
        $stmt->bindValue(":ugId", $obj->getUgId());
        $stmt->bindValue(":rating", $obj->getRating());
        $stmt->bindValue(":mime", $obj->getMime());
        $stmt->bindValue(":image", $obj->getImage());
        $stmt->bindValue(":disabled", $obj->isDisabled());
        $stmt->bindValue(":id", $obj->getId());

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('Update UserModel error...');
        }
    }

    public function delete($id)
    {
    }

    public function readAll()
    {
        $sql = "SELECT * FROM user";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('Error UserModel readAll');
        }
    }

    public function readByMail($mail)
    {
        $query = "SELECT * FROM user WHERE mail = :mail";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":mail", $mail);

        if($stmt->execute()){
           return $stmt->fetch();
        } else {
            throw new PDOException('UserModel select mail error...');
        }
    }


}