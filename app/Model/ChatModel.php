<?php
namespace Model;

use Model\DAO\MessageDAO;

class ChatModel {
    private $msgID;
    private $from;
    private $to;
    private $message;
    private $date;

    /**
     * ChatModel constructor.
     * @param $msgID
     * @param $fromID
     * @param $senderID
     * @param $message
     * @param $date
     */
    public function __construct($msgID, $fromID, $senderID, $message, $date)
    {
        $this->msgID = $msgID;
        $this->from = $fromID;
        $this->to = $senderID;
        $this->message = $message;
        $this->date = $date;
    }

    /**
     * Insert model into database
     * @param MessageDAO $messageDAO
     * @param $message
     * @return mixed
     */
    public static function insertIntoDatabase($messageDAO, $message)
    {
        return $messageDAO->create($message);
    }

    /**
     * Returns all models by sender id from database
     * @param MessageDAO $messageDAO
     * @param $senderId
     * @return array
     */
    public static function getFromDatabase($messageDAO, $senderId)
    {
        $result = $messageDAO->readBySenderId($senderId);

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new ChatModel($row[0], $row[1], $row[2], $row[3], $row[4]);
        endforeach;

        return $returnArray;

    }

    /**
     * Returns all model from
     * @param $messageDAO
     * @param $id
     * @return array
     */
    public static function getFromDatabaseOrder($messageDAO, $id)
    {
        $result = $messageDAO->readIdWithOrder($id);

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new ChatModel($row[0], $row[1], $row[2], $row[3], $row[4]);
        endforeach;

        return $returnArray;

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->msgID;
    }

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param mixed $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return mixed
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}
