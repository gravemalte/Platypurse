<?php

namespace Model;

use Hydro\Base\Database\Driver\SQLite;
use Hydro\Base\Model\BaseModel;
use Hydro\Helper\Date;
use PDO;

class OfferGridModel extends BaseModel {

    private $o_id;
    private $name;
    private $price;
    private $negotiable;
    private $description;

    /**
     * OfferGridModel constructor.
     * @param $o_id
     * @param $name
     * @param $price
     * @param $negotiable
     * @param $description
     */
    public function __construct($o_id, $name, $price, $negotiable, $description)
    {
        $this->o_id = $o_id;
        $this->name = $name;
        $this->price = $price;
        $this->negotiable = $negotiable;
        $this->description = $description;
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getOId()
    {
        return $this->o_id;
    }

    /**
     * @param mixed $o_id
     */
    public function setOId($o_id): void
    {
        $this->o_id = $o_id;
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
    public function getPrice()
    {
        return number_format($this->price/100, 2, ',', '.');
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getNegotiable()
    {
        return $this->negotiable;
    }

    /**
     * @param mixed $negotiable
     */
    public function setNegotiable($negotiable): void
    {
        $this->negotiable = $negotiable;
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
    public function setDescription($description): void
    {
        $this->description = $description;
    }
}