<?php

namespace Model;

use Hydro\Base\Model\BaseModel;
use Hydro\Helper\DataSerialize;
use Hydro\Helper\FileWriter;

class UserModel extends BaseModel {
    const file = DB . 'userData.dat';

    private $userID;
    private $displayName;
    private $email;
    private $password;

    /**
     * UserModel constructor.
     * @param $displayName
     * @param $email
     * @param $password
     */
    public function __construct($displayName, $email, $password)
    {
        $this->userID = uniqid();
        $this->displayName = $displayName;
        $this->email = $email;
        $this->password = $password;
    }

    private function writeUserToFile($userSZ){
        FileWriter::writeToFile(self::file, $userSZ);
    }

    public function registerUser($user){
        $userSZ = DataSerialize::serializeData($user);
        $this->writeUserToFile($userSZ);
    }


    // TODO: Rewrite to a clear update function
    public static function updateUser($user){
        $s = serialize($user);
        FileWriter::writeToFile(self::file, $s);

    }

    public static function getData(){
        if(!file_exists(self::file)){
            FileWriter::createFile(self::file);
        }

        if(FileWriter::fileIsEmpty(self::file)){
            return false;
        }

        $loginFile = fopen(self::file, 'r');
        $myData = fread($loginFile, filesize(self::file));
        $data_array = explode("\n", $myData);

        fclose($loginFile);
        return $data_array;
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