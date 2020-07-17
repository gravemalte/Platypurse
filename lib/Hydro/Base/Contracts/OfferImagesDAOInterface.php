<?php

namespace Hydro\Base\Contracts;

interface OfferImagesDAOInterface
{
    public function create($obj);
    public function readByOfferId($id);
    public function update($obj);
}