<?php

namespace Hydro\Base\Contracts;

interface RegisterTokenDAOInterface
{
    public function create($obj);
    public function read($id);
    public function deleteExpired();
    public function deleteForUser($id);
}