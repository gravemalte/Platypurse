<?php

namespace Hydro\Base\Contracts;

interface DAOContract
{
    public function create();
    public function read();
    public function update();
    public function delete();
}