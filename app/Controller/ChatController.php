<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
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

    public static function getChatHistory() {
        if(!(isset($_SESSION['currentUser']))) {
            http_response_code(401);
            echo json_encode(array());
            return;
        }

        $messages = ChatModel::getMessages($_SESSION['currentUser']->getId());
        $result = array();

        foreach ($messages as $message){
            $result[] = array(COLUMNS_MESSAGE['sender_id'] => $message->getFrom(),
                COLUMNS_MESSAGE['receiver_id'] => $message->getTo(),
                COLUMNS_MESSAGE['message']=>$message->getMessage(),
                COLUMNS_MESSAGE['send_date']=>$message->getDate());
        }

        echo json_encode($result);
    }



    public function sendMessage(){
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

        $chat->sendMessageToDatabase();

    }

    /*
    public function getMessage($userID, $receiverID){

        $result = array();
        $messages = ChatModel::getMessages($userID);


        foreach ($messages as $message){
            $result[] = array(COLUMNS_MESSAGE['sender_id'] => $message->getFrom(),
                COLUMNS_MESSAGE['receiver_id'] => $message->getTo(),
                COLUMNS_MESSAGE['message']=>$message->getMessage(),
                COLUMNS_MESSAGE['send_date']=>$message->getDate());
        }

        return json_encode($result);
    }

    public function getMyMessage(){

    }
    */

}