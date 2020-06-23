<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use PDOException;

class UserModel extends BaseModel
{
    private $id;
    private $displayName;
    private $mail;
    private $password;
    private $ugId;
    private $rating;
    private $createdAt;
    private $picture;
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
     * @param $picture;
     * @param $disabled
     */
    public function __construct($id, $displayName, $mail, $password, $ugId, $rating, $createdAt, $picture, $disabled)
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
            $picture[COLUMNS_USER['mime']] = $row[COLUMNS_USER["mime"]];
            $picture[COLUMNS_USER['image']] = $row[COLUMNS_USER["image"]];

            $user[] = new UserModel($row[COLUMNS_USER["u_id"]],
                $row[COLUMNS_USER["display_name"]],
                $row[COLUMNS_USER["mail"]],
                $row[COLUMNS_USER["password"]],
                $row[COLUMNS_USER["ug_id"]],
                $row[COLUMNS_USER["rating"]],
                $row[COLUMNS_USER["created_at"]],
                $picture,
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
            $this->getPicture()[COLUMNS_SAVED_OFFERS['mime']],
            $this->getPicture()[COLUMNS_SAVED_OFFERS['image']],
            $this->isDisabled());
    }

    public function insertRatingIntoDatabase($from, $rating) {
        $con = SQLite::connectToSQLite();
        $result = false;
        $con->beginTransaction();
        try {
            $statement = "INSERT INTO " . TABLE_USER_RATING . "(";
            foreach (COLUMNS_USER_RATING as $col):
                $statement .= $col . ", ";
            endforeach;
            $statement = substr($statement, 0, -2) . ") VALUES (";
            $valueArray = array();
            foreach (COLUMNS_USER_RATING as $col):
                $statement .= "?, ";
            endforeach;
            $statement = substr($statement, 0, -2) . ");";


            $valueArray($from, $this->getId(), $rating);
            //print($statement);
            //print_r($valueArray);

            $command = $con->prepare($statement);
            $result = $command->execute($valueArray);
            $con->commit();
        }
        catch(PDOException $ex) {
            $con->rollBack();
            $return = false;
        }
        finally {
            unset($con);
            return $return;
        }
    }

    public function getUserRatingFromDatabase() {
        $con = SQLite::connectToSQLite();
        $statement = "SELECT AVG(" .COLUMNS_USER_RATING['rating']. ") AS " .COLUMNS_USER_RATING['rating'].
            " FROM " .TABLE_USER_RATING. " WHERE " .COLUMNS_USER_RATING['for_u_id']. " = ?;";

        $command = $con->prepare($statement);
        $command->execute(array($this->getId()));
        $result = $command->fetch();

        return $result[COLUMNS_USER_RATING['rating']];
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
    public function getPictureArray()
    {
        return $this->picture;
    }

    /**
     * @param mixed $picture
     */
    public function setPictureArray($picture)
    {
        $this->picture = $picture;
    }

    public function getPicture() {
        $picture = $this->getPicture();
        if(!empty($picture)):
            return "data:" .$picture[COLUMNS_USER['mime']].
                ";base64," .$picture[COLUMNS_USER['image']];
        else:
            return null;
        endif;
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
