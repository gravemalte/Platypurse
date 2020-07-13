<?php

namespace Hydro\Base\Contracts;

interface ZipCoordinatesDAOInterface
{
    public function readByZipcode($zipcode);
}