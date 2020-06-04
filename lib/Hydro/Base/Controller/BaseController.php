<?php

namespace Hydro\Base\Controller;

class BaseController {
    
    public $db = null;

    public $model = null;


    function __construct()
    {

    }

    private function openDBConn()
    {
        // TODO: Implementing a Database connection
    }
}