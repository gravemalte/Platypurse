<?php

namespace Model;

class ZipCoordinatesModel {
    private $id;
    private $loc_id;
    private $zipcode;
    private $name;
    private $lat;
    private $lon;

    /**
     * ZipCoordinatesModel constructor.
     * @param $id
     * @param $loc_id
     * @param $zipcode
     * @param $name
     * @param $lat
     * @param $lon
     */
    public function __construct($id, $loc_id, $zipcode, $name, $lat, $lon)
    {
        $this->id = $id;
        $this->loc_id = $loc_id;
        $this->zipcode = $zipcode;
        $this->name = $name;
        $this->lat = $lat;
        $this->lon = $lon;
    }

    public static function getFromDatabaseByZipcode($zipCoordinatesDAO, $zipcode) {
        $result = $zipCoordinatesDAO->readByZipcode($zipcode);

        return new ZipCoordinatesModel($result[0], $result[1], $result[2], $result[3], $result[4], $result[5]);
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
    public function getLocId()
    {
        return $this->loc_id;
    }

    /**
     * @param mixed $loc_id
     */
    public function setLocId($loc_id): void
    {
        $this->loc_id = $loc_id;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat): void
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * @param mixed $lon
     */
    public function setLon($lon): void
    {
        $this->lon = $lon;
    }
}