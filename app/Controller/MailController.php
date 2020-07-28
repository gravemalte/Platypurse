<?php


namespace Controller;

use \Model\DAO\MailDAO;
use \Hydro\Base\Database\Driver\SQLite;
use \Model\MailModel;


class MailController
{

    public function index() {

        if (!isset($_GET['id'])) {
            header('location: ' . URL . 'error/unauthorized');
            exit();
        }

        // load views
        require APP . 'View/mail/header.php';
        require APP . 'View/mail/index.php';
    }

    public static function getMailContent() {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            header('location: ' . URL . 'error/unauthorized');
            exit();
        }

        $dao = new MailDAO(SQLite::connectToSQLite());
        $mail = MailModel::getFromDatabase($dao, $_GET['id']);

        if (!$mail->exists()) {
            http_response_code(404);
            header('location: ' . URL . 'error');
            exit();
        }

        echo $mail->getContent();
    }

    public static function previewTemplate() {
        require APP . 'View/mail/templates/verifyAccount.php';
    }
}