<?php

namespace Hydro\Base\Contracts;

interface RegisterTokenDAOInterface
{
    public function create($obj);
    public function read($id);
    public function update($obj);
}