<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    private $entityManager;

    private $compare;

    private $userMatchRepository;

    private $ageFiltrationService;

    private $budgetFiltrationService;

    private $genderService;

    private $matchPercentService;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserCompareService $compareService,
        UserMatchRepository $userMatchRepository,
        AgeFiltrationService $ageFiltrationService,
        BudgetFiltrationService $budgetFiltrationService,
        GenderFiltrationService $genderService,
        MatchPercentFiltrationService $matchPercentService
    ) {
        $this->entityManager = $entityManager;
        $this->compare = $compareService;
        $this->userMatchRepository = $userMatchRepository;
        $this->ageFiltrationService = $ageFiltrationService;
        $this->budgetFiltrationService = $budgetFiltrationService;
        $this->genderService = $genderService;
        $this->matchPercentService = $matchPercentService;
    }

    public function filter($matches, array $formParameters): ?array
    {
        $filteredUsers = $matches;
        if ($formParameters["gender"] != null && !empty($filteredUsers)) {
            $filteredUsers =
                $this->genderService->findMatchesByGender(
                    $filteredUsers,
                    $formParameters["gender"]
                );
        }
        if ($formParameters['budget'] != null && !empty($filteredUsers)) {
            $filteredUsers =
                $this->budgetFiltrationService->filterByBudget(
                    $filteredUsers,
                    $formParameters["budget"]
                );
        }
        if (!empty($filteredUsers)) {
            $filteredUsers = $this
                ->ageFiltrationService->filterByAge(
                    $filteredUsers,
                    [$formParameters["minAge"], $formParameters["maxAge"]]
                );
        }
        if (!empty($filteredUsers) && $formParameters['MatchPercent'] != null) {
            $filteredUsers =
                $this->matchPercentService->filterByMatchPercent(
                    $filteredUsers,
                    $formParameters['MatchPercent']
                );
        }

        return ($filteredUsers);
    }

    public function getPossibleMatch(User $user): array
    {
        $users = $this->userMatchRepository->findMatches($user->getId());

        return $users;
    }

    public function addNewMatchesToDatabase($users, User $user): void
    {
        $query =
            "INSERT INTO user_match (first_user, second_user, coeficient) VALUES ";
        $i = 1;

        foreach ($users as $oneUser) {
            if ($i === 1) {
                $query .= "('";
            } else {
                $query .= ",('";
            }

            $query .= $user->getId() . "','" . $oneUser->getId() . "',"
                . round($this->compare->getMatchPercent($user, $oneUser));
            $query .= ")";
            $i++;
        }

        $this->userMatchRepository->query($query);
    }

    private function deleteUserInfoAboutMatches(User $user): void
    {
        $query = "DELETE FROM user_match WHERE first_user = ";
        $query .= "'";
        $query .= $user->getId();
        $query .= "'";

        $this->userMatchRepository->query($query);
    }

    public function addMatchWithoutFiltration(User $user): void
    {
        $this->deleteUserInfoAboutMatches($user);
        if ($user->getQuestionnaireScore() != null && $user->getDateOfBirth() != null) {
            $users = $this->entityManager->getRepository(User::class)
                ->findBy(['city' => $user->getCity(), 'isActive' => 1]);
            if (sizeof($users) > 1) {
                $users = $this->compare->filterByAnswers($users, $user, 50);
                $this->addNewMatchesToDatabase($users, $user);
            }
        }
    }
}
