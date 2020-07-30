<?php
namespace Model\DAO;

use Hydro\Base\Contracts\MessageDAOInterface;
use Model\ChatModel;
use PDOException;

class MessageDAO implements MessageDAOInterface
{
    private $con;

    /**
     * MessageDAO constructor.
     * @param $con
     */
    public function __construct($con)
    {
        $this->con = $con;
    }

    /**
     * Insert entry into database
     * @param ChatModel $obj
     * @return mixed
     */
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
            throw new PDOException('MessageDAO create error ' . $stmt->errorInfo());
        }

    }

    /**
     * Read entry by id from database
     * @param $senderId
     * @return mixed
     */
    public function readBySenderId($senderId)
    {
        $query = "SELECT * FROM message WHERE sender_id = :id;";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $senderId);

        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            throw new PDOException('MessageDAO read error ' . $stmt->errorInfo());
        }
    }

    /**
     * Read models by id from database, ordered ascending by
     * @param $id
     * @return mixed
     */
    public function readIdWithOrder($id)
    {
        $query = "SELECT * FROM message WHERE sender_id = :id ORDER BY msg_id ASC";

        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()){
            return $stmt->fetchAll();
        } else {
            throw new PDOException('MesseageDAO readIdWithOrder error ' . $stmt->errorInfo());
        }
    }

}