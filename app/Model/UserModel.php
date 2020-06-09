<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;

class UserModel extends BaseModel
{
    // TODO: Write with queryBuilder
    const TABLE = "user";
    const TABLECOLUMNS = array(
        "u_id" => "u_id",
        "display_name" => "display_name",
        "mail" => "mail",
        "password" => "password",
        "ug_id" => "ug_id",
        "rating" => "rating",
        "created_at" => "created_at",
        "disabled" => "disabled");

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
            return SQLITE::insertBuilder(self::TABLE, self::TABLECOLUMNS, $insertValues);
        }
    }


    public function checkUser($userEmail, $displayName)
    {
        $selectValues = array(self::TABLECOLUMNS["mail"],
            self::TABLECOLUMNS["display_name"]);
        $whereClause = self::TABLECOLUMNS["mail"]. " = ? OR "
            .self::TABLECOLUMNS["display_name"]. " = ?";

        $result = SQLite::selectBuilder($selectValues,
            self::TABLE,
            $whereClause,
            array($userEmail, $displayName));

        if(sizeof($result) > 0):
            return true;
        else:
            return false;
        endif;
    }

    public static function checkCredentials($userEmail, $userPasswd)
    {
        $whereClause = self::TABLECOLUMNS["mail"]. " = ? AND "
            .self::TABLECOLUMNS["password"]. " = ?";

        $result = SQLite::selectBuilder(self::TABLECOLUMNS,
            self::TABLE,
            $whereClause,
            array($userEmail, $userPasswd));

        if($result == null):
            return false;
        else:
            return $result;
        endif;
    }

    public static function searchUser($id){
        $whereClause = self::TABLECOLUMNS["u_id"]. " = ?";

        $result = SQLite::selectBuilder(self::TABLECOLUMNS,
            self::TABLE,
            $whereClause,
            array($id));

        foreach ($result as $row):
            return new UserModel($row[self::TABLECOLUMNS["u_id"]],
                $row[self::TABLECOLUMNS["display_name"]],
                $row[self::TABLECOLUMNS["mail"]],
                $row[self::TABLECOLUMNS["password"]],
                $row[self::TABLECOLUMNS["ug_id"]],
                $row[self::TABLECOLUMNS["rating"]],
                $row[self::TABLECOLUMNS["created_at"]],
                $row[self::TABLECOLUMNS["display_name"]]);
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
    public function setId($id): void
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
    public function setDisplayName($displayName): void
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
    public function setMail($mail): void
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
    public function setPassword($password): void
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
    public function setUgId($ugId): void
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
    public function setRating($rating): void
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
    public function setCreatedAt($createdAt): void
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
    public function setDisabled($disabled): void
    {
        $this->disabled = $disabled;
    }
}
