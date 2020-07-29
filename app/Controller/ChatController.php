<?php
namespace Controller;

use Hydro\Base\Controller\BaseController;
use Hydro\Base\Database\Driver\SQLite;
use Hydro\Helper\Date;
use Model\ChatModel;
use Model\DAO\MessageDAO;
use Model\DAO\UserDAO;
use Model\UserModel;
use PDOException;

class ChatController extends BaseController
{
    public function index(){
        if(!(isset($_SESSION['currentUser']))){
            header('location: ' .URL . 'login');
        }
        $_SESSION['csrf_token'] = uniqid();

        require APP . 'View/shared/header.php';
        require APP . 'View/chat/header.php';
        require APP . 'View/shared/nav.php';
        require APP . 'View/chat/index.php';
        require APP . 'View/shared/footer.php';
    }

    public static function getChatHistory() {
        header('Content-Type: application/json');

        if(!(isset($_SESSION['currentUser']))) {
            http_response_code(401);
            echo json_encode(array());
            return;
        }

        $userID = $_SESSION['currentUser']->getId();

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $messages = ChatModel::getFromDatabase(new MessageDAO($con), $userID);
            unset($sqlite);
        } catch (PDOException $ex) {
            unset($sqlite);
            header('location: ' . URL . 'error/databaseError');
            exit();
        }

        $result = array();

        foreach($messages as $msg):
            $result[] = array(
                "msg_id" => $msg->getId(),
                "sender_id" => $msg->getFrom(),
                "receiver_id" => $msg->getTo(),
                "message" => $msg->getMessage(),
                "send_date" => $msg->getDate()
            );
        endforeach;


        echo json_encode(array('chat' => $result, 'date' => Date::now()));
    }

    public static function getNewMessages() {
        header('Content-Type: application/json');

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

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $messages = ChatModel::getFromDatabaseOrder(new MessageDAO($con), $userID);
            unset($sqlite);
        } catch (PDOException $ex) {
            unset($sqlite);
            header('location: ' . URL . 'error/databaseError');
            exit();
        }
        unset($sqlite);

        $result = array();

        foreach($messages as $msg):
            $result[] = array(
                "msg_id" => $msg->getId(),
                "sender_id" => $msg->getFrom(),
                "receiver_id" => $msg->getTo(),
                "message" => $msg->getMessage(),
                "send_date" => $msg->getDate()
            );
        endforeach;


        echo json_encode(array('chat' => $result, 'date' => Date::now()));
    }

    public static function getUserDisplayName() {
        header('Content-Type: text/plain');

        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo 0;
            return;
        }

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $user = UserModel::getUser(new UserDAO($con),
                $_GET['id']);
            unset($sqlite);
        } catch (PDOException $ex) {
            header('location: ' . URL . 'error/databaseError');
            unset($sqlite);
            exit();
        }

        if ($user->getUgId() == 3) {
            echo '<em>' . $user->getDisplayName() . '</em>';
            return;
        }

        echo $user->getDisplayName();
    }

    public static function sendMessage() {
        header('Content-Type: application/json');

        if(!(isset($_SESSION['currentUser'])) || ($_POST['csrf'] != $_SESSION['csrf_token'])) {
            http_response_code(401);
            echo json_encode(array());
            exit();
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

        $sqlite = new SQLite();
        try {
            $sqlite->openTransaction();
            $con = $sqlite->getCon();
            $dao = new MessageDAO($con);

            $messages = ChatModel::insertIntoDatabase($dao, $newMessage);

            if ($messages) {
                http_response_code(500);
                echo json_encode(array());
                return;
            }

            $userID = $_SESSION['currentUser']->getId();

            $messages = ChatModel::getFromDatabase($dao, $userID);

            $result = array();

            foreach($messages as $msg):
                $result[] = array(
                    "msg_id" => $msg->getId(),
                    "sender_id" => $msg->getFrom(),
                    "receiver_id" => $msg->getTo(),
                    "message" => $msg->getMessage(),
                    "send_date" => $msg->getDate()
                );
            endforeach;

            $sqlite->closeTransaction(true);
            unset($sqlite);
            echo json_encode(array('chat' => $result, 'date' => Date::now()));
        } catch (PDOException $e) {
            $sqlite->closeTransaction(false);
            header('location: ' . URL . 'error/databaseError');
            exit();
        }
    }
}
