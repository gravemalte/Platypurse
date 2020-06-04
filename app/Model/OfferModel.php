<?php

namespace Model;

use Hydro\Base\Model\BaseModel;
use Hydro\Helper\FileWriter;

class OfferModel extends BaseModel {
    const file = DB . 'offerData.dat';

    private $id;
    private $title;
    private $description;
    private $price;
    private $sex;
    private $age;
    private $size;

    public function __construct($title = "", $description = "", $price = "", $sex = "", $age = "", $size = "", $id = "")
    {
        if(empty($id)): $this->id = uniqid();
        else: $this->id = $id;
        endif;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->sex = $sex;
        $this->age = $age;
        $this->size = $size;
    }

    private function writeOfferToFile($offer){
        $s = serialize($offer);
        FileWriter::writeToFile(self::file, $s);
    }

    public function createOffer($offer){
        $this->writeOfferToFile($offer);
    }

    public static function deleteOfferFromFile($id) {
        $offerFile = fopen(self::file, 'r');
        $myData = fread($offerFile, filesize(self::file));
        $dataArray = explode("\n", $myData);
        $mode = "w+";

        // Searches for id and removes the entry from the array
        unset($dataArray[sizeof($dataArray) - 1]);
        foreach ($dataArray as $key => $value) {
            if (!(false !== stripos($value, $id))) {
                FileWriter::writeToFile(self::file, $value, $mode);
                $mode = "a+";
            }
        }

        // print_r($dataArray);*/
        fclose($offerFile);
    }

    public function updateOffer($offer) {
        $this->deleteOfferFromFile($offer->getId());
        $this->writeOfferToFile($offer);
    }

    public function __toString()
    {
        return "$this->title" .
            "$this->description" .
            "$this->price" .
            "$this->sex" .
            "$this->age" .
            "$this->size";
    }

    public static function getData($searchStr = ""){
        $offerFile = fopen(self::file, 'r');
        $myData = fread($offerFile, filesize(self::file));
        $dataArray = explode("\n", $myData);
        fclose($offerFile);

        // If searchStr is not empty, search the array for matching results and pass them into the return array
        if($searchStr != "") {
            $tempArray = array();
            foreach($dataArray as $data) {
                if(strpos(strtolower ($data), strtolower ($searchStr)) !== false) {
                    $tempArray[] = $data;
                }
            }
            // Quick solution as long we don't have a proper database
            $tempArray[] = "";

            $dataArray = $tempArray;
        }

        return $dataArray;
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
        $this->title = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex;
    }

    /**
     * @param string $sex
     */
    public function setSex(string $sex): void
    {
        $this->sex = $sex;
    }

    /**
     * @return string
     */
    public function getAge(): string
    {
        return $this->age;
    }

    /**
     * @param string $age
     */
    public function setAge(string $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getSize(): string
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize(string $size): void
    {
        $this->size = $size;
    }

}