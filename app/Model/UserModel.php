<?php

namespace Model;

use Model\DAO\UserDAO;

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
    private $verified;

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
     * @param $verified
     */
    public function __construct($id, $displayName, $mail, $password, $ugId, $rating, $createdAt, $mime, $image,
                                $disabled, $verified)
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
        $this->verified = $verified;
    }

    /**
     * Insert model into database
     * @param UserDAO $userDAO
     * @return mixed
     */
    public function insertIntoDatabase($userDAO) {
            return $userDAO->create($this);
    }

    /**
     * Returns model by mail from database
     * @param UserDAO $userDAO
     * @param $mail
     * @return UserModel
     */
    public static function getFromDatabaseByMail($userDAO, $mail){
        $row = $userDAO->readByMail($mail);
        return self::getUserFromRow($row);
    }

    /**
     * Returns model by id from database
     * @param UserDAO $userDAO
     * @param $id
     * @return UserModel
     */
    public static function getFromDatabaseById($userDAO, $id){
        $row = $userDAO->read($id);
        return self::getUserFromRow($row);
    }

    /**
     * Returns model by name from database
     * @param UserDAO $userDAO
     * @param $name
     * @return UserModel
     */
    public static function getFromDatabaseByName($userDAO, $name) {
        $row = $userDAO->readByName($name);
        return self::getUserFromRow($row);
    }

    /**
     * Update model in database
     * @param UserDAO $userDAO
     * @return mixed
     */
    public function updateInDatabase($userDAO) {
        return $userDAO->update($this);
    }

    /**
     * Set disabled to 1 and update model in database
     * @param UserDAO $dao
     */
    public function deactivateInDatabase($dao) {
        $this->setDisabled(1);
        $this->updateInDatabase($dao);
    }

    /**
     * Set disabled to 0 and update model in database
     * @param UserDAO $dao
     */
    public function activateInDatabase($dao) {
        $this->setDisabled(0);
        $this->updateInDatabase($dao);
    }

    /**
     * Set verified to 1 and update model in database
     * @param UserDAO $dao
     */
    public function verify($dao) {
        $this->setVerified(1);
        $this->updateInDatabase($dao);
    }

    /**
     * Returns model from database row
     * @param $row
     * @return UserModel
     */
    private static function getUserFromRow($row) {
        return new UserModel($row[0], $row[1], $row[2], $row[3], $row[4], $row[5],
            $row[6], $row[7], $row[8], $row[9], $row[10]);
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

    public function isSupport(){
        return $this->ugId == 3;
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

    /**
     * @return mixed
     */
    public function isVerified()
    {
        return $this->verified;
    }

    /**
     * @param mixed $verified
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;
    }

    public static function getUser($dao, $id) {
        return self::getFromDatabaseById($dao, $id);
    }
}
