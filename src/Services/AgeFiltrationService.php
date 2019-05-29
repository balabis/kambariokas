<?php

namespace App\Services;

class AgeFiltrationService
{
    private $minAge;

    private $maxAge;

    public function __construct()
    {
        $this->maxAge = 80;
        $this->minAge = 18;
    }

    public function filterByAge($users, array $age)
    {
        if ($age[0] === null && $age[1] !== null) {
            $users = $this->filterBySetAge($users, [$this->minAge, $age[1]]);
        } elseif ($age[0] != null && $age[1] === null) {
            $users = $this->filterBySetAge($users, [$age[0], $this->maxAge]);
        } elseif ($age[0] != null && $age[1] != null) {
            $users = $this->filterBySetAge($users, $age);
        }

        return $users;
    }

    private function filterBySetAge($users, array $age) :array
    {
        $filterUsers = [];

        foreach ($users as $user) {
            if ($user->getUserAge() >= $age[0] && $user->getUserAge() <= $age[1]) {
                $filterUsers[] = $user;
            }
        }

        return $filterUsers;
    }
}
