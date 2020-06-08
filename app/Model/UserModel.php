<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;

class UserModel extends BaseModel
{
    // TODO: Write with queryBuilder
    const TABLE = "user";
    const TABLECOLUMNS = array(
        ":user_id" => "user_id",
        ":display_name" => "display_name",
        ":mail" => "mail",
        ":password" => "password"
    );

    private $userID;
    private $email;
    private $displayName;
    private $password;

    /**
     * UserModel constructor.
     * @param $displayName
     * @param $email
     * @param $password
     */

    public function __construct($displayName, $email, $password)
    {
        $this->userID = hexdec(uniqid());
        $this->email = $email;
        $this->displayName = $displayName;
        $this->password = $password;
        parent::__construct();
    }

    public function registerUser()
    {
        if ($this->checkUser($this->email, $this->displayName) == true) {
            return false;
        } else {
            $sql_query = "INSERT INTO user (display_name, mail, password, ug_id) VALUES (:display_name, :mail, :password, :user_id)";
            $query = $this->db->prepare($sql_query);
            $query->bindParam(":display_name", $this->displayName);
            $query->bindParam(":mail", $this->email);
            $query->bindParam(":password", $this->password);
            $query->bindParam(":user_id", $this->userID);
            $query->execute();
            unset($query);
            return true;
        }
    }


    public function checkUser($userEmail, $displayName)
    {
        $sql_query = "SELECT mail, display_name FROM user WHERE mail = :mail OR display_name = :display_name";
        $stmt = $this->db->prepare($sql_query);
        $stmt->bindParam(':mail', $userEmail);
        $stmt->bindParam(':display_name', $displayName);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkCredentials($userEmail, $userPasswd)
    {
        $sql_query = "SELECT * FROM user WHERE mail = '$userEmail' AND password = '$userPasswd'";
        $con = SQLite::connectToSQLite();
        $query = $con->prepare($sql_query);
        $query->execute();
        $obj = $query->fetchObject();
        if ($obj == null) {
            return false;
        } else {
            return array(true, "userID" => $obj->ug_id, "display_name" => $obj->display_name,
                "mail" => $obj->mail);
        }
    }

    public static function searchUser($id){
        $con = SQLite::connectToSQLite();
        $sql_query = "SELECT * FROM user WHERE ug_id = '$id'";
        $query = $con->prepare($sql_query);
        $query->execute();
        $obj = $query->fetchObject();
        if($obj == null){
            return array(false);
        }else {
            return array(true, "userID"=> $obj->ug_id,"display_name" => $obj->display_name,
                "mail" => $obj->mail);
        }
    }

    /**
     * @return string
     */
    public function getUserID()
    {
        return $this->userID;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
}
