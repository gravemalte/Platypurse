<?php

namespace Hydro\Base\Contracts;

interface PlatypusDAOInterface
{
    public function create($obj);
    public function read($id);
    public function update($obj);
}