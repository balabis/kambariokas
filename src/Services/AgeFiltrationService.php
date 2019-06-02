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
            if ($this->getUserAge($user) >= $age[0] && $this->getUserAge($user) <= $age[1]) {
                $filterUsers[] = $user;
            }
        }

        return $filterUsers;
    }

    private function getUserAge($user)
    {
        $dateOfBirth = new \DateTime($user->date_of_birth);
        $today = date('Y-m-d');
        if (isset($dateOfBirth)) {
            $dateOfBirth = $dateOfBirth->format('Y-m-d');
        }
        if (isset($dateOfBirth)) {
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            return $diff->format('%y');
        } else {
            return null;
        }
    }
}
