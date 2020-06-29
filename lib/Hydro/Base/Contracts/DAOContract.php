<?php

namespace Hydro\Base\Contracts;

interface DAOContract
{
    public function create($value);
    public function read($values);
    public function update($values);
    public function delete($values);
}