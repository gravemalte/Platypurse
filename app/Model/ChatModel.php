<?php


namespace Model;


use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;

class ChatModel extends BaseModel
{
    private $from;
    private $to;
    private $message;
    private $date;

    public function __construct($fromID, $senderID, $message, $date)
    {
        $this->from = $fromID;
        $this->to = $senderID;
        $this->message = $message;
        $this->date = $date;
        parent::__construct();
    }

    public function sendMessageToDatabase(){
        $insertValues = array(
            $this->getFrom(),
            $this->getTo(),
            $this->getMessage(),
            $this->getDate()
        );

        SQLite::insertBuilder(TABLE_MESSAGE, COLUMNS_MESSAGE, $insertValues);
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

    public static function getMessages($userID){
        $whereClause = COLUMNS_MESSAGE["sender_id"] .  " = ? OR " . COLUMNS_MESSAGE["receiver_id"] .  " = ?";
        $chat = array();
        $result = SQLite::selectBuilder(COLUMNS_MESSAGE, TABLE_MESSAGE,
            $whereClause, array($userID, $userID));
        foreach ($result as $row){
            $chat[] = new ChatModel(
                $row[COLUMNS_MESSAGE['sender_id']],
                $row[COLUMNS_MESSAGE['receiver_id']],
                $row[COLUMNS_MESSAGE['message']],
                $row[COLUMNS_MESSAGE['send_date']]);
        }

        return $chat;
    }

}