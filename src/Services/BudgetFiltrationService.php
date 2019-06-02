<?php

namespace App\Services;

class BudgetFiltrationService
{
    public function filterByBudget(array $users, string $budget) : array
    {
        $filteredUsers = [];
        $budgets = [
            'iki 50eur/mėn' => 0,
            'iki 100eur/mėn' => 1,
            'iki 200eur/mėn' => 2,
            '> 200eur/mėn' => 3
        ];

        $filterBudgetType = $budgets[$budget];

        foreach ($users as $user) {
            $userBudgetType = $budgets[$user->budget];
            if ($filterBudgetType <= $userBudgetType) {
                $filteredUsers[] = $user;
            }
        }

        return $filteredUsers;
    }
}
