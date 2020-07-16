<?php
namespace Model\DAO;

use Hydro\Base\Contracts\UserDAOInterface;
use PDOException;

class UserDAO implements UserDAOInterface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $query = "INSERT INTO user(u_id, display_name, mail, password, ug_id, mime, image)
            VALUES (:userID, :displayName, :mail, :password, :ugID, :mime, :image);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":userID", $obj->getId());
        $stmt->bindValue(":displayName", $obj->getDisplayName());
        $stmt->bindValue(":mail", $obj->getMail());
        $stmt->bindValue(":password", $obj->getPassword());
        $stmt->bindValue(":ugID", $obj->getUgId());
        $stmt->bindValue(":mime", $obj->getMime());
        $stmt->bindValue(":image", $obj->getImage());


        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM user WHERE u_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            return new PDOException('UserDAO create error');
        }

    }

    public function read($id)
    {
        $query = "SELECT * FROM user WHERE u_id = :id;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('UserDAO read error');
        }
    }

    public function readByMail($mail)
    {
        $query = "SELECT * FROM user WHERE mail = :mail;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":mail", $mail);

        if($stmt->execute()){
            return $stmt->fetch();
        } else {
            throw new PDOException('UserDAO readByMail error');
        }
    }

    public function update($obj)
    {
        $sql = "UPDATE user SET display_name = :displayName, mail = :mail, password = :password, ug_id = :ugId,
                rating = :rating, mime = :mime, image = :image, disabled = :disabled, verified = :verified
                WHERE u_id = :id;";

        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":displayName", $obj->getDisplayName());
        $stmt->bindValue(":mail", $obj->getMail());
        $stmt->bindValue(":password", $obj->getPassword());
        $stmt->bindValue(":ugId", $obj->getUgId());
        $stmt->bindValue(":rating", $obj->getRating());
        $stmt->bindValue(":mime", $obj->getMime());
        $stmt->bindValue(":image", $obj->getImage());
        $stmt->bindValue(":disabled", $obj->isDisabled());
        $stmt->bindValue(":verified", $obj->isVerified());
        $stmt->bindValue(":id", $obj->getId());

        if($stmt->execute()) {
            return true;
        } else {
            throw new PDOException('UserDAO update error');
        }
    }
}