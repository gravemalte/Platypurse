<?php
namespace Model\DAO;

use PDOException;
use Hydro\Base\Contracts\DAOContract;

class DAOMessage implements DAOContract
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }


    public function create($obj)
    {
        $query = "INSERT INTO message(msg_id, sender_id, receiver_id, message, send_date) VALUES (:msgId, :senderId, :receiverId, :message, :sendDate)";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":msgId", $obj->getId());
        $stmt->bindValue(":senderId", $obj->getFrom());
        $stmt->bindValue(":receiverId", $obj->getTo());
        $stmt->bindValue(":message", $obj->getMessage());
        $stmt->bindValue(":sendDate", $obj->getDate());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM message WHERE sender_id = $id";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            return new PDOException('MessageModel statement exception');
        }

    }

    public function read($id)
    {
        $query = "SELECT * FROM message WHERE sender_id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            throw new PDOException('MessageModel select error...');
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
        $stmt->bindValue(":mime", $obj->getPicture()[0]);
        $stmt->bindValue(":image", $obj->getPicture()[1]);
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



    public function readIdWithOrder($id)
    {
        $query = "SELECT * FROM message WHERE sender_id = :id ORDER BY msg_id ASC";

        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            throw new PDOException('MessageModel select error...');
        }
    }

    public function readAll()
    {
        $sql = "SELECT * FROM message";
        $stmt = $this->con->prepare($sql);

        if($stmt->execute()) {
            return $stmt->fetchAll();
        } else {
            throw new PDOException('Error UserModel readAll');
        }
    }

}