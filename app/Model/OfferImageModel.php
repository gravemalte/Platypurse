<?php

namespace Model;

use Model\DAO\OfferImageDAO;

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

    /**
     * Insert model into database
     * @param OfferImageDAO $offerImageDAO
     * @return mixed
     */
    public function insertIntoDatabase($offerImageDAO) {
        return $offerImageDAO->create($this);
    }

    /**
     * Return model by offer id from database
     * @param OfferImageDAO $offerImageDAO
     * @param $offerId
     * @return OfferImageModel
     */
    public static function getFromDatabaseByOfferId($offerImageDAO, $offerId) {
        $result = $offerImageDAO->readByOfferId($offerId);
        $return = new OfferImageModel(uniqid(), $offerId, 0, "", "");
        if($result):
            $return = new OfferImageModel($result[0], $result[1], $result[2], $result[3], $result[4]);
        endif;
        return $return;
    }

    /**
     * Update model in database
     * @param OfferImageDAO $dao
     * @return mixed
     */
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
    public function setId($id)
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
    public function setOfferId($offerId)
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
    public function setPicturePosition($picturePosition)
    {
        $this->picturePosition = $picturePosition;
    }

    /**
     * @return mixed
     */
    public function getMime()
    {
        $mime = $this->mime;
        // Returns placeholder offer mime in case of no mime in database
        if(empty($mime)):
            $mime = "png";
        endif;
        return $mime;
    }

    /**
     * @param mixed $mime
     */
    public function setMime($mime)
    {
        $this->mime = $mime;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        $image = $this->image;
        // Returns placeholder offer image in case of no image in database
        if(empty($image)):
            $image = base64_encode(file_get_contents("assets/placeholder/offer.png"));
        endif;
        return $image;
    }

    public function getSrc() {
        return "data:" .$this->getMime().
            ";base64," .$this->getImage();
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
}