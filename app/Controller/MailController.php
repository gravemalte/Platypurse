<?php


namespace Controller;

use Hydro\Base\Controller\BaseController;
use \Model\DAO\MailDAO;
use \Hydro\Base\Database\Driver\SQLite;
use \Model\MailModel;


class MailController extends BaseController
{

    public function index() {

        if (!isset($_GET['id'])) {
            http_response_code(404);
            header('location: ' . URL . 'error/pageNotFound');
            exit();
        }

        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new MailDAO($con);
        $mail = MailModel::getFromDatabase($dao, $_GET['id']);
        unset($sqlite);

        if (!$mail->exists()) {
            http_response_code(404);
            header('location: ' . URL . 'error/mailContentError');
            exit();
        }

        // load views
        require APP . 'View/mail/header.php';
        require APP . 'View/mail/index.php';
    }

    public static function getMailContent() {
        if (!isset($_GET['id'])) {
            http_response_code(404);
            header('location: ' . URL . 'error/subPageNotFound');
            exit();
        }

        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new MailDAO($con);
        $mail = MailModel::getFromDatabase($dao, $_GET['id']);
        unset($sqlite);

        if (!$mail->exists()) {
            http_response_code(404);
            header('location: ' . URL . 'error/pageNotFound');
            exit();
        }

        header('Content-Type: text/html');
        echo html_entity_decode($mail->getContent());
    }

    public static function previewTemplate() {
        require APP . 'View/mail/templates/duplicateMail.php';
    }
}