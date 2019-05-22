<?php

namespace App\Services;

class AgeFiltrationService
{
    public function filterByAge($users, array $age)
    {
        $filteredUsers = [];
        var_dump($age);
        if ($age[0] == null) {
            //Todo: select only if value smaller then age1
        } elseif ($age[1] == null) {
            //Todo:select only if value bigger then value0
        } else {
            //todo:bigger than age1, smaller then age0
        }

        return $users;
    }

}
