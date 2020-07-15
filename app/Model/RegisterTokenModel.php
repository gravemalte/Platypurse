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
    private $active;

    /**
     * RegisterTokenModel constructor.
     * @param $id
     * @param $token
     * @param $user
     * @param $expirationDate
     * @param $active
     */
    public function __construct($id, $token, $user, $expirationDate, $active)
    {
        $this->id = $id;
        $this->token = $token;
        $this->user = $user;
        $this->expirationDate = $expirationDate;
        $this->active = $active;
    }

    public function insertIntoDatabase($dao) {
        return $dao->create($this);
    }

    public static function getFromDatabase($dao, $id) {
        $result = $dao->read($id);
        return new RegisterTokenModel($result[0], $result[1],
            UserModel::getFromDatabaseById(new UserDAO($dao->getCon()),$result[2]),
            $result[3], $result[4]);
    }
    
    public function updateInDatabase($dao) {
        return $dao->update($this);
    }

    public function generate($user) {
        $id = null;
        $token = bin2hex(random_bytes(5));
        $expirationDate = date("Y-m-d H:i:s", time() + 3600);
        $active = true;

        $token = new self($id, $token, $user, $expirationDate, $active);
        $dao = new RegisterTokenDAO(SQLite::connectToSQLite());
        return $token->insertIntoDatabase($dao);
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

    /**
     * @return mixed
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active): void
    {
        $this->active = $active;
    }
}