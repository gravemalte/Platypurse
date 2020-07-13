<?php

namespace Hydro\Base\Contracts;

interface SavedOffersDAOInterface
{
    public function create($obj);
    public function readByUserId($id);
    public function readByUserIdAndOfferId($userId, $offerId, $withActives);
    public function update($obj);
}