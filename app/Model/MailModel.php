<?php

namespace Model;

use Model\DAO\UserDAO;

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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
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
    public function setContent($content): void
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
    public function setReceiverName($receiverName): void
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
    public function setReceiverUser($receiverUser): void
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
    public function setReceiverMail($receiverMail): void
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
    public function setSendDate($sendDate): void
    {
        $this->sendDate = $sendDate;
    }

    public function exists(): bool {
        return $this->getContent() != "";
    }
}