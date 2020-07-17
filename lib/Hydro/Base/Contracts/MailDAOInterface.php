<?php

namespace Hydro\Base\Contracts;

interface MailDAOInterface
{
    public function create($obj);
    public function read($id);
}