<?php

namespace Hydro\Base\Contracts;

interface DAOContract
{
    public function create($connection);
    public static function read($connection, $where, $values);
    public function update($connection, $values);
    public function delete($connection, $values);
}