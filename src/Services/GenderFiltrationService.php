<?php


namespace App\Services;

class GenderFiltrationService
{
    public function findMatchesByGender($matches, $gender)
    {
        $filteredUsers = [];
        if ($gender !== 'default') {
            foreach ($matches as $match) {
                if ($match->gender === $gender) {
                    $filteredUsers[] = $match;
                }
            }
        } else {
            $filteredUsers = $matches;
        }

        return $filteredUsers;
    }
}
