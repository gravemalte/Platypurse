<?php


namespace Controller;

use Hydro\Base\Controller\BaseController;
use \Model\DAO\MailDAO;
use \Hydro\Base\Database\Driver\SQLite;
use \Model\MailModel;
use PDOException;


class MailController extends BaseController
{

    public function index() {

        if (!isset($_GET['id'])) {
            http_response_code(404);
            header('location: ' . URL . 'error/pageNotFound');
            exit();
        }

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new MailDAO($con);
            $mail = MailModel::getFromDatabase($dao, $_GET['id']);
            unset($sqlite);
        } catch (PDOException $ex) {
            unset($sqlite);
            die(header('location: ' . URL . 'error/databaseError'));
        }

        if (!$mail->exists()) {
            http_response_code(404);
            header('location: ' . URL . 'error/mailContentError');
            exit();
        }

        // load views
        require APP . 'View/mail/header.php';
        require APP . 'View/mail/index.php';
    }

    public static function getMail($id) {
        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new MailDAO($con);
            unset($sqlite);
            return MailModel::getFromDatabase($dao, $id);
        } catch (PDOException $ex) {
            unset($sqlite);
            die(header('location: ' . URL . 'error/databaseError'));
        }
    }

    public static function getMailContent() {
        if (!isset($_GET['id'])) {
            http_response_code(404);
            header('location: ' . URL . 'error/subPageNotFound');
            exit();
        }

        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new MailDAO($con);
            $mail = MailModel::getFromDatabase($dao, $_GET['id']);
            unset($sqlite);
        } catch (PDOException $ex) {
            unset($sqlite);
            die(header('location: ' . URL . 'error/databaseError'));
        }

        if (!$mail->exists()) {
            http_response_code(404);
            header('location: ' . URL . 'error/pageNotFound');
            exit();
        }

        header('Content-Type: text/html');
        echo html_entity_decode($mail->getContent());
    }

    public static function previewTemplate() {
        require APP . 'View/mail/templates/resetPassword.php';
    }
}