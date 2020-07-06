<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Model\DAO\DAOUser;

class UserModel
{
    private $id;
    private $displayName;
    private $mail;
    private $password;
    private $ugId;
    private $rating;
    private $createdAt;
    private $mime;
    private $image;
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
     * @param $mime;
     * @param $image;
     * @param $disabled
     */
    public function __construct($id, $displayName, $mail, $password, $ugId, $rating, $createdAt, $mime, $image, $disabled)
    {
        $this->id = $id;
        $this->displayName = htmlspecialchars(strip_tags($displayName));
        $this->mail = htmlspecialchars(strip_tags($mail), FILTER_SANITIZE_EMAIL);
        $this->password = $password;
        $this->ugId = $ugId;
        $this->rating = $rating;
        $this->createdAt = $createdAt;
        $this->mime = $mime;
        $this->image = $image;
        $this->disabled = $disabled;
    }

    public function insertIntoDatabase($userDAO) {
        return $userDAO->create($this);
    }

    public static function getFromDatabaseByMail($userDAO, $mail){
        $tmp = $userDAO->readByMail($mail);
        return new UserModel($tmp[0], $tmp[1], $tmp[2], $tmp[3], $tmp[4], $tmp[5], $tmp[6], $tmp[7], $tmp[8], $tmp[9]);;
    }

    public static function getFromDatabaseById($userDAO, $id){
        $tmp = $userDAO->read($id);
        return new UserModel($tmp[0], $tmp[1], $tmp[2], $tmp[3], $tmp[4], $tmp[5], $tmp[6], $tmp[7], $tmp[8], $tmp[9]);;
    }


    public function updateInDatabase($userDAO) {
        return $userDAO->update($this);
    }

    /**
     * Set active to 0 and update database
     * @param $dao
     */
    public function deactivateInDatabase($dao) {
        $this->setDisabled(1);
        $this->updateInDatabase($dao);
    }

    /**
     * Set active to 0 and update database
     * @param $dao
     */
    public function activateInDatabase($dao) {
        $this->setDisabled(0);
        $this->updateInDatabase($dao);
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

    public function getMime() {
        return $this->mime;
    }

    public function setMime($mime) {
        $this->mime = $mime;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getPicture() {
            return "data:" . $this->getMime() .
                ";base64," . $this->getImage();
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

    public static function getUser($id) {
        return self::getFromDatabaseById(new DAOUser(SQLite::connectToSQLite()), $id);
    }
}
