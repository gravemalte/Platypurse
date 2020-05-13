<?php

namespace Platypurse\Base\Controller;

class BaseController {
    
    public $db = null;

    public $model = null;


    function __construct()
    {
        $this->openDBConn();
    }

    private function openDBConn()
    {
        // TODO: Implement this
    }
}