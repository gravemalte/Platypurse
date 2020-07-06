<?php


namespace Model;

use Controller\ChatController;

class ChatModel {
    private $msgID;
    private $from;
    private $to;
    private $message;
    private $date;

    public function __construct($msgID, $fromID, $senderID, $message, $date)
    {
        $this->msgID = $msgID;
        $this->from = $fromID;
        $this->to = $senderID;
        $this->message = $message;
        $this->date = $date;
    }

    public static function insertIntoDatabase($messageDAO, $message)
    {
        return $messageDAO->create($message);
    }

    public static function getFromDatabase($messageDAO, $id)
    {
        $result = $messageDAO->read($id);

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new ChatModel($row[0], $row[1], $row[2], $row[3], $row[4]);
        endforeach;

        return $returnArray;

    }

    public static function getFromDatabaseOrder($messageDAO, $id)
    {
        $result = $messageDAO->readIdWithOrder($id);

        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new ChatModel($row[0], $row[1], $row[2], $row[3], $row[4]);
        endforeach;

        return $returnArray;

    }


    public function getDatabaseValues()
    {
        return array($this->getId(),
            $this->getFrom(),
            $this->getTo(),
            $this->getMessage(),
            $this->getDate());
    }

    public function getId()
    {
        return $this->msgID;
    }

    public function sendMessageToDatabase(){
        $insertValues = array(
            $this->getFrom(),
            $this->getTo(),
            $this->getMessage(),
            $this->getDate()
        );

        //SQLite::insertBuilder(TABLE_MESSAGE, COLUMNS_MESSAGE, $insertValues);
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
