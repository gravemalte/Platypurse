<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Hydro\Helper\Date;
use Model\ChatModel;

class ChatController extends BaseController
{
    public function index(){
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' .URL . 'login');
        }

        require APP . 'View/shared/header.php';
        require APP . 'View/chat/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/chat/index.php';
        require APP . 'View/shared/footer.php';
    }



    public function sentMessage(){
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' .URL . 'login');
        }

        if(!(isset($_POST['message']))){
            header('location: ' .URL . 'chat');
        }

        $fromID = $_POST['from-id'];
        $toID = $_POST['to-id'];
        $message = $_POST['message'];
        $date = Date::now();

        $chat = new ChatModel($fromID, $toID, $message, $date);

        $chat->sentMessageToDatabase();

    }

    public static function getMessage(){
        $userID = $_SESSION['currentUser']->getId();
        $whereClause = "WHERE " .COLUMNS_MESSAGE["sender_id"].  " = ? ";

        $result = array();
        $messages = ChatModel::getFromDatabase(SQLite::connectToSQLite(), $whereClause, array($userID));

        foreach ($messages as $message){
            $result[] = array(COLUMNS_MESSAGE['sender_id'] => $message->getFrom(),
                COLUMNS_MESSAGE['receiver_id'] => $message->getTo(),
                COLUMNS_MESSAGE['message']=>$message->getMessage(),
                COLUMNS_MESSAGE['send_date']=>$message->getDate());
        }

        echo json_encode($result);
    }


}