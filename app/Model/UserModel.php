<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;

class UserModel extends BaseModel
{
    private $id;
    private $displayName;
    private $mail;
    private $password;
    private $ugId;
    private $rating;
    private $createdAt;
    private $disabled;

    /**
     * UserModel constructor.
     * @param $id
     * @param $displayName
     * @param $mail
     * @param $password
     * @param $ugId
     * @param $rating
     * @param $createdAt
     * @param $disabled
     */
    public function __construct($id, $displayName, $mail, $password, $ugId, $rating, $createdAt, $disabled)
    {
        $this->id = $id;
        $this->displayName = $displayName;
        $this->mail = $mail;
        $this->password = $password;
        $this->ugId = $ugId;
        $this->rating = $rating;
        $this->createdAt = $createdAt;
        $this->disabled = $disabled;
        parent::__construct();
    }


    public function registerUser()
    {
        if ($this->checkUser($this->getMail(), $this->getDisplayName()) == true) {
            return false;
        } else {
            $insertValues = array($this->getId(),
                $this->getDisplayName(),
                $this->getMail(),
                $this->getPassword(),
                $this->getUgId(),
                $this->getRating(),
                $this->getCreatedAt(),
                $this->getDisabled());
            return SQLITE::insertBuilder(TABLE_USER, COLUMNS_USER, $insertValues);
        }
    }


    public function checkUser($userEmail, $displayName)
    {
        $selectValues = array(COLUMNS_USER["mail"],
            COLUMNS_USER["display_name"]);
        $whereClause = COLUMNS_USER["mail"]. " = ? OR "
            .COLUMNS_USER["display_name"]. " = ?";

        $result = SQLite::selectBuilder($selectValues,
            TABLE_USER,
            $whereClause,
            array($userEmail, $displayName));

        if(sizeof($result) > 0):
            return true;
        else:
            return false;
        endif;
    }

    public static function searchUserEmail($userEmail)
    {
        $whereClause = COLUMNS_USER["mail"]. " = ?";

        $result = SQLite::selectBuilder(COLUMNS_USER,
            TABLE_USER,
            $whereClause,
            array($userEmail));

        if($result == null):
            return false;
        else:
            return $result;
        endif;
    }

    public static function searchUser($id){
        $whereClause = COLUMNS_USER["u_id"]. " = ?";

        $result = SQLite::selectBuilder(COLUMNS_USER,
            TABLE_USER,
            $whereClause,
            array($id));

        foreach ($result as $row):
            return new UserModel($row[COLUMNS_USER["u_id"]],
                $row[COLUMNS_USER["display_name"]],
                $row[COLUMNS_USER["mail"]],
                $row[COLUMNS_USER["password"]],
                $row[COLUMNS_USER["ug_id"]],
                $row[COLUMNS_USER["rating"]],
                $row[COLUMNS_USER["created_at"]],
                $row[COLUMNS_USER["display_name"]]);
        endforeach;
        return false;
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
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param mixed $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUgId()
    {
        return $this->ugId;
    }

    /**
     * @param mixed $ugId
     */
    public function setUgId($ugId)
    {
        $this->ugId = $ugId;
    }

    /**
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->ugId == 1;
    }

    /**
     * @return mixed
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param mixed $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getDisabled()
    {
        return $this->disabled;
    }

    /**
     * @param mixed $disabled
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;
    }
}
