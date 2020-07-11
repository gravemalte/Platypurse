<?php

namespace Hydro\Base\Contracts;

interface UserDAOInterface
{
    public function create($obj);
    public function read($id);
    public function readByMail($mail);
    public function update($obj);
}