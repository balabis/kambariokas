<?php


namespace App\Services;

use App\Entity\User;

class FlatService
{
    public function filterByFlat($users, User $user) :array
    {
        return $users;
    }
}
