<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\MailDAO;
use Model\DAO\UserDAO;
use Hydro\Helper\Date;
use PDOException;

class MailModel {
    private $id;
    private $content;
    private $receiverName;
    private $receiverUser;
    private $receiverMail;
    private $sendDate;

    /**
     * MailModel constructor.
     * @param $id
     * @param $content
     * @param $receiverName
     * @param $receiverUser
     * @param $receiverMail
     * @param $sendDate
     */
    public function __construct($id, $content, $receiverName, $receiverUser, $receiverMail, $sendDate)
    {
        $this->id = $id;
        $this->content = $content;
        $this->receiverName = $receiverName;
        $this->receiverUser = $receiverUser;
        $this->receiverMail = $receiverMail;
        $this->sendDate = $sendDate;
    }

    /**
     * Insert model into database
     * @param MailDAO $dao
     * @return mixed
     */
    public function insertIntoDatabase($dao) {
        return $dao->create($this);
    }

    public static function getFromDatabase($dao, $id) {
        $result = $dao->read($id);
        return new MailModel($result[0], $result[1], $result[2],
            UserModel::getFromDatabaseById(new UserDAO($dao->getCon()),$result[3]),
            $result[4], $result[5]);
    }

    /**
     * Returns model based on user and content
     * @param $user
     * @param $content
     * @return MailModel
     */
    public static function initMail($user, $content) {
        $mail = new MailModel(null, $content, $user->getDisplayName(), $user, $user->getMail(), Date::now());
        $sqlite = new SQLite();
        try {
            $con = $sqlite->getCon();
            $dao = new MailDAO($con);
            $sqlite->openTransaction();

            $result = $mail->insertIntoDatabase($dao);
            $model = new MailModel($result[0], $result[1], $result[2], $result[3], $result[4], $result[5]);

            $sqlite->closeTransaction(true);
            return $model;
        } catch (PDOException $ex) {
            $sqlite->closeTransaction(false);
            header('location: ' . URL . 'error/databaseError');
        }
        unset($sqlite);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getReceiverName()
    {
        return $this->receiverName;
    }

    /**
     * @param mixed $receiverName
     */
    public function setReceiverName($receiverName)
    {
        $this->receiverName = $receiverName;
    }

    /**
     * @return mixed
     */
    public function getReceiverUser()
    {
        return $this->receiverUser;
    }

    /**
     * @param mixed $receiverUser
     */
    public function setReceiverUser($receiverUser)
    {
        $this->receiverUser = $receiverUser;
    }

    /**
     * @return mixed
     */
    public function getReceiverMail()
    {
        return $this->receiverMail;
    }

    /**
     * @param mixed $receiverMail
     */
    public function setReceiverMail($receiverMail)
    {
        $this->receiverMail = $receiverMail;
    }

    /**
     * @return mixed
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * @param mixed $sendDate
     */
    public function setSendDate($sendDate)
    {
        $this->sendDate = $sendDate;
    }

    public function exists() {
        return $this->getContent() != "";
    }
}