<?php


namespace App\Services;

class MatchPercentFiltrationService
{
    public function filterByMatchPercent(
        $matches,
        $filterPercent
    ): array {
        $filteredUsers = [];
        foreach ($matches as $user) {
            if ($user->coeficient >= intval($filterPercent)) {
                $filteredUsers[] = $user;
            }
        }

        return $filteredUsers;
    }
}
