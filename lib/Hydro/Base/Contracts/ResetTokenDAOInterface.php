<?php

namespace Hydro\Base\Contracts;

interface ResetTokenDAOInterface
{
    public function create($obj);
    public function read($token);
    public function deleteExpired();
    public function deleteForUser($id);
}