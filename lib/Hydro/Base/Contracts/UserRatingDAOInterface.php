<?php

namespace Hydro\Base\Contracts;

interface UserRatingDAOInterface
{
    public function create($obj);
    public function readForUserId($forUserId);
    public function readFromUserIdForUserId($fromUserId, $forUserId);
    public function update($obj);
}