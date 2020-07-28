<?php
namespace Model\DAO;

use Hydro\Base\Contracts\MessageDAOInterface;
use PDOException;

class MessageDAO implements MessageDAOInterface
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function create($obj)
    {
        $query = "INSERT INTO message(msg_id, sender_id, receiver_id, message, send_date)
            VALUES (:msgId, :senderId, :receiverId, :message, :sendDate);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":msgId", $obj->getId());
        $stmt->bindValue(":senderId", $obj->getFrom());
        $stmt->bindValue(":receiverId", $obj->getTo());
        $stmt->bindValue(":message", $obj->getMessage());
        $stmt->bindValue(":sendDate", $obj->getDate());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM message WHERE sender_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            throw new PDOException('MessageDAO create error');
        }

    }

    public function read($id)
    {
        $query = "SELECT * FROM message WHERE sender_id = :id;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            throw new PDOException('MessageDAO read error');
        }
    }
}