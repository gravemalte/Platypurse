<?php
namespace Model\DAO;

use Hydro\Base\Contracts\MailDAOInterface;
use PDOException;

class MailDAO implements MailDAOInterface
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
        $query = "INSERT INTO mails (m_id, content, receiver_name, receiver_id, receiver_mail, send_date) 
            VALUES (:id, :content, :receiverName, :receiverId, :receiverMail, :sendDate);";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(":id", $obj->getId());
        $stmt->bindValue(":content", $obj->getContent());
        $stmt->bindValue(":receiverName", $obj->getReceiverName());
        $stmt->bindValue(":receiverId", $obj->getReceiverUser()->getId());
        $stmt->bindValue(":receiverMail", $obj->getReceiverMail());
        $stmt->bindValue(":sendDate", $obj->getSendDate());

        if($stmt->execute()) {
            $id = $this->con->lastInsertId();
            $sql = "SELECT * FROM mails WHERE m_id = $id;";
            $result = $this->con->query($sql);
            return $result->fetch();
        } else {
            throw new PDOException('MailDAO create error');
        }
    }

    public function read($id)
    {
        $sql = "SELECT * FROM mails
                    WHERE m_id = :id;";
        $stmt = $this->con->prepare($sql);
        $stmt->bindValue(":id", $id);

        if($stmt->execute()) {
            return $stmt->fetch();
        } else {
            throw new PDOException('MailDAO read error');
        }
    }
}