<?php

namespace App\Services;

class BudgetFiltrationService
{
    public function filterByBudget(array $users, string $budget) : array
    {
        $filteredUsers = [];
        foreach ($users as $user) {
            if ($user->getBudget() === $budget) {
                $filteredUsers[] = $user;
            }
        }
        return $filteredUsers;
    }
}
