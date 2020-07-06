<?php


namespace Controller;


use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Hydro\Helper\Date;
use Model\ChatModel;
use Model\DAO\DAOMessage;
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

        $userID = $_SESSION['currentUser']->getId();

        $messages = ChatModel::getFromDatabase(new DAOMessage(SQLite::connectToSQLite()), $userID);

        $result = array();

        foreach($messages as $msg):
            $result[] = array(
                "messageId" => $msg->getId(),
                "senderId" => $msg->getFrom(),
                "receiverId" => $msg->getTo(),
                "message" => $msg->getMessage(),
                "sendDate" => $msg->getDate()
            );
        endforeach;


        echo json_encode(array('chat' => $result, 'date' => Date::now()));
    }

    public static function getNewMessages() {
        if(!(isset($_SESSION['currentUser']))) {
            http_response_code(401);
            echo json_encode(array());
            return;
        }

        if(!(isset($_GET['latest-id']))) {
            http_response_code(400);
            echo json_encode(array());
            return;
        }

        $userID = $_SESSION['currentUser']->getId();

        $messages = ChatModel::getFromDatabaseOrder(new DAOMessage(SQLite::connectToSQLite()), $userID);

        $result = array();

        foreach($messages as $msg):
            $result[] = array(
                "messageId" => $msg->getId(),
                "senderId" => $msg->getFrom(),
                "receiverId" => $msg->getTo(),
                "message" => $msg->getMessage(),
                "sendDate" => $msg->getDate()
            );
        endforeach;


        echo json_encode(array('chat' => $result, 'date' => Date::now()));
    }

    public static function getUserDisplayName() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo 0;
            return;
        }

        echo UserModel::getUser($_GET['id'])->getDisplayName();
    }

    public static function sendMessage() {
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


        $newMessage = new ChatModel(null, $fromID, $toID, $message, $date);

        $messages = ChatModel::insertIntoDatabase(new DAOMessage(SQLite::connectToSQLite()), $newMessage);

        if ($messages) {
            http_response_code(500);
            echo json_encode(array());
            return;
        }

        $userID = $_SESSION['currentUser']->getId();

        $messages = ChatModel::getFromDatabase(new DAOMessage(SQLite::connectToSQLite()), $userID);

        $result = array();

        foreach($messages as $msg):
            $result[] = array(
                "messageId" => $msg->getId(),
                "senderId" => $msg->getFrom(),
                "receiverId" => $msg->getTo(),
                "message" => $msg->getMessage(),
                "sendDate" => $msg->getDate()
            );
        endforeach;

        echo json_encode(array('chat' => $result, 'date' => Date::now()));
    }
}
