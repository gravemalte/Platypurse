<?php

namespace Hydro\Base\Model;

use Hydro\Base\Contracts\DAOContract;


abstract class BaseModel implements DAOContract {

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
    }
}