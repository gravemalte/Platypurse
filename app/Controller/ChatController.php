<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Hydro\Helper\Date;
use Model\ChatModel;
use Model\UserModel;

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

        $whereClause = "WHERE "
            . COLUMNS_MESSAGE["sender_id"]
            . " = ? OR "
            . COLUMNS_MESSAGE["receiver_id"]
            . " = ? ORDER BY "
            . COLUMNS_MESSAGE["send_date"]
            . " ASC";
        $userID = $_SESSION['currentUser']->getId();

        $messages = ChatModel::getFromDatabase(SQLite::connectToSQLite(), $whereClause, array($userID, $userID));
        $result = array();

        foreach ($messages as $message){
            $result[] = array(
                COLUMNS_MESSAGE['msg_id'] => $message->getId(),
                COLUMNS_MESSAGE['sender_id'] => $message->getFrom(),
                COLUMNS_MESSAGE['receiver_id'] => $message->getTo(),
                COLUMNS_MESSAGE['message']=>$message->getMessage(),
                COLUMNS_MESSAGE['send_date']=>$message->getDate()
            );
        }

        echo json_encode($result);
    }

    public static function getUserDisplayName() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo 0;
            return;
        }

        echo UserModel::getUser($_GET['id'])->getDisplayName();
    }

    public static function sendMessage(){
        if(!(isset($_SESSION['currentUser']))) {
            http_response_code(401);
            echo json_encode(array());
            return;
        }

        if (!(isset($_POST['message']) && isset($_POST['to-id']))) {
            http_response_code(400);
            echo json_encode(array());
            return;
        }

        $fromID = $_SESSION['currentUser']->getId();
        $toID = $_POST['to-id'];
        $message = $_POST['message'];
        $date = Date::now();

        $chat = new ChatModel(null, $fromID, $toID, $message, $date);

        $chat->sendMessageToDatabase();

    }
}
