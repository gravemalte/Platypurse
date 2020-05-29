<?php

namespace Model;

use Hydro\Base\Model\BaseModel;
use Hydro\Helper\FileWriter;

class UserModel extends BaseModel {
    const file = DB . 'userData.dat';


    private $email;
    private $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    private function writeUserToFile($user){
        $s = serialize($user);
        FileWriter::writeToFile(self::file, $s);
    }

    public function registerUser($user){
        $this->writeUserToFile($user);
    }

    public function __toString()
    {
        return "$this->email" .
            "$this->password";
    }

    public static function getData(){
        $loginFile = fopen(self::file, 'r');
        $myData = fread($loginFile, filesize(self::file));
        $data_array = explode("\n", $myData);

        fclose($loginFile);
        return $data_array;
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
    public function setEmail($email): void
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
    public function setPassword($password): void
    {
        $this->password = $password;
    }
}