<?php

namespace Hydro\Base\Contracts;

interface MessageDAOInterface
{
    public function create($obj);
    public function read($id);
    //public function readOrderedById($id);
}