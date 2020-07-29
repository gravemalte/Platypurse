<?php

namespace Hydro\Base\Contracts;

interface OfferDAOInterface
{
    public function create($obj);
    public function read($id);
    public function readHot();
    public function readNewest();
    public function readOffersByUserId($userId);
    public function readSearchResults($getCount, $keyedSearchValuesArray);
    public function update($obj);
}