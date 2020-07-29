<?php

namespace Hydro\Base\Contracts;

interface MessageDAOInterface
{
    public function create($obj);
    public function readBySenderId($senderId);
    public function readIdWithOrder($id);
}