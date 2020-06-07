<?php

namespace Model;

use Hydro\Base\Model\BaseModel;

class UserModel extends BaseModel
{
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
        $sql_query = "SELECT * FROM user WHERE mail = :user_mail OR display_name = :display_name" ;
        $stmt = $this->db->prepare($sql_query);
        $stmt->bindParam(':user_mail', $userEmail);
        $stmt->bindParam(':display_name', $displayName);
        $stmt->execute();
        $count = $stmt->rowCount();
        if ($count >= 0){
            return true;
        }else{
            return false;
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