<?php

namespace Hydro\Base\Contracts;

interface DAOContract
{
    public function create($obj);
    public function read($id);
    public function update($obj);
    public function delete($id);
    public function readAll();
}