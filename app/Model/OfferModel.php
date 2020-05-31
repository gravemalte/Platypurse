<?php

namespace Model;

use Hydro\Base\Model\BaseModel;
use Hydro\Helper\DataSerialize;
use Hydro\Helper\FileWriter;

class OfferModel extends BaseModel {
    const file = DB . 'offerData.dat';

    private $id;
    private $title;
    private $description;
    private $price;
    private $categories;

    public function __construct($title, $description, $price, $categories)
    {
        $this->id = uniqid();
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->categories = $categories;
    }

    private function writeOfferToFile($offer){
        $s = serialize($offer);
        FileWriter::writeToFile(self::file, $s);
    }

    public function createOffer($offer){
        $this->writeOfferToFile($offer);
    }

    public function deleteOffer($offer) {

    }

    public function modifyOffer($offer) {
        $newOffer = $offer;
    }

    public function __toString()
    {
        return "$this->title" .
            "$this->description" .
            "$this->price" .
            "$this->categories";
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
     * @return mixed
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param mixed $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

}