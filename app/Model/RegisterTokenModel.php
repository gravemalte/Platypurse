<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\UserDAO;
use Model\DAO\RegisterTokenDAO;

class RegisterTokenModel {
    private $id;
    private $token;
    private $user;
    private $expirationDate;

    /**
     * RegisterTokenModel constructor.
     * @param $id
     * @param $token
     * @param $user
     * @param $expirationDate
     */
    public function __construct($id, $token, $user, $expirationDate)
    {
        $this->id = $id;
        $this->token = $token;
        $this->user = $user;
        $this->expirationDate = $expirationDate;
    }

    /**
     * Insert model into database
     * @param RegisterTokenDAO $dao
     * @return mixed
     */
    public function insertIntoDatabase($dao) {
        return $dao->create($this);
    }

    /**
     * Returns model by id from database
     * @param RegisterTokenDAO $dao
     * @param $id
     * @return RegisterTokenModel
     */
    public static function getFromDatabase($dao, $id) {
        $result = $dao->read($id);
        return new RegisterTokenModel($result[0], $result[1],
            UserModel::getFromDatabaseById(new UserDAO($dao->getCon()),$result[2]),
            $result[3]);
    }

    /**
     * Returns model by token from database
     * @param RegisterTokenDAO $dao
     * @param $token
     * @return RegisterTokenModel
     */
    public static function getFromDatabaseByToken($dao, $token) {
        $result = $dao->readByToken($token);
        return new RegisterTokenModel(
            $result[0],
            $result[1],
            UserModel::getFromDatabaseById(new UserDAO($dao->getCon()), $result[2]),
            $result[3]
        );
    }

    /**
     * Deletes expired models in database
     * @param RegisterTokenDAO $dao
     * @return mixed
     */
    public static function deleteExpiredFromDatabase($dao) {
        return $dao->deleteExpired();
    }

    /** Deletes model for user id in database
     * @param RegisterTokenDAO $dao
     * @param $userId
     * @return mixed
     */
    public static function deleteForUserFromDatabase($dao, $userId) {
        return $dao->deleteForUser($userId);
    }

    /**
     * Generates new model for user
     * @param UserModel $user
     * @return RegisterTokenModel
     * @throws \Exception
     */
    public static function generate($user) {
        $id = null;
        $token = bin2hex(random_bytes(5));
        $expirationDate = date("Y-m-d H:i:s", time() + 3600);
        $token = new self($id, $token, $user, $expirationDate);
        $sqlite = new SQLite();
        $con = $sqlite->getCon();
        $dao = new RegisterTokenDAO($con);
        // TODO: Try catch
        $result = $token->insertIntoDatabase($dao);
        $model = new RegisterTokenModel($result[0], $result[1], $result[2], $result[3]);
        unset($sqlite);
        return $model;
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
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getExpirationDate()
    {
        return $this->expirationDate;
    }

    /**
     * @param mixed $expirationDate
     */
    public function setExpirationDate($expirationDate): void
    {
        $this->expirationDate = $expirationDate;
    }
}