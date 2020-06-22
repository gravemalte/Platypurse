<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;

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
        parent::__construct(TABLE_USER, COLUMNS_USER);
    }

    public function insertIntoDatabase($con) {
        return $this->create($con);
    }

    public static function getFromDatabase($con, $whereClause, $values) {

        $result = parent::read($con, TABLE_USER. " " .$whereClause, $values);
        $user = array();
        foreach ($result as $row):
            $user[] = new UserModel($row[COLUMNS_USER["u_id"]],
                $row[COLUMNS_USER["display_name"]],
                $row[COLUMNS_USER["mail"]],
                $row[COLUMNS_USER["password"]],
                $row[COLUMNS_USER["ug_id"]],
                $row[COLUMNS_USER["rating"]],
                $row[COLUMNS_USER["created_at"]],
                $row[COLUMNS_USER["disabled"]]);
        endforeach;

        if(count($user) == 1):
            $user = array_shift($user);
        endif;

        return $user;
    }

    public function updateInDatabase($con, $editDate = true) {
        return $this->update($con);;
    }

    /**
     * Set active to 0 and update database
     */
    public function deactivateInDatabase() {
        $this->setDisabled(1);
        $this->updateInDatabase(SQLite::connectToSQLite());
    }

    /**
     * @return array
     */
    public function getDatabaseValues() {
        return array($this->getId(),
            $this->getDisplayName(),
            $this->getMail(),
            $this->getPassword(),
            $this->getUgId(),
            $this->getRating(),
            $this->getCreatedAt(),
            $this->isDisabled());
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
     * @param boolean $shallHash
     */
    public function setPassword($password, $shallHash = true)
    {
        if ($shallHash) $password = password_hash($password, PASSWORD_DEFAULT);
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
    public function isDisabled()
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
