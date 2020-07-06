<?php

namespace Model;

class OfferImageModel {
    private $id;
    private $offerId;
    private $picturePosition;
    private $mime;
    private $image;

    /**
     * OfferImageModel constructor.
     * @param $id
     * @param $offerId
     * @param $picturePosition
     * @param $mime
     * @param $image
     */
    public function __construct($id, $offerId, $picturePosition, $mime, $image)
    {
        $this->id = $id;
        $this->offerId = $offerId;
        $this->picturePosition = $picturePosition;
        $this->mime = $mime;
        $this->image = $image;
    }

    public function insertIntoDatabase($offerImageDAO) {
        return $offerImageDAO->create($this);
    }

    public static function getFromDatabaseByOfferId($offerImageDAO, $offerId) {
        $result = $offerImageDAO->readByOfferId($offerId);
        $returnArray = array();
        foreach($result as $row):
            $returnArray[] = new OfferImageModel($row[0], $row[1], $row[2], $row[3], $row[4]);
        endforeach;

        return $returnArray;
    }
    
    public function updateInDatabase($dao) {
        return $dao->update($this);
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
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getOfferId()
    {
        return $this->offerId;
    }

    /**
     * @param mixed $offerId
     */
    public function setOfferId($offerId): void
    {
        $this->offerId = $offerId;
    }

    /**
     * @return mixed
     */
    public function getPicturePosition()
    {
        return $this->picturePosition;
    }

    /**
     * @param mixed $picturePosition
     */
    public function setPicturePosition($picturePosition): void
    {
        $this->picturePosition = $picturePosition;
    }

    /**
     * @return mixed
     */
    public function getMime()
    {
        return $this->mime;
    }

    /**
     * @param mixed $mime
     */
    public function setMime($mime): void
    {
        $this->mime = $mime;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getSrc() {
        return "data:" .$this->getMime().
            ";base64," .$this->getImage();
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }
}