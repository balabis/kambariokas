<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    private $entityManager;

    private $city;

    private $compare;

    private $userMatchRepository;

    private $ageFiltrationService;

    private $budgetFiltrationService;

    public function __construct(
        EntityManagerInterface $entityManager,
        CityService $cityService,
        UserCompareService $compareService,
        UserMatchRepository $userMatchRepository,
        AgeFiltrationService $ageFiltrationService,
        BudgetFiltrationService $budgetFiltrationService
    ) {
        $this->entityManager = $entityManager;
        $this->city = $cityService;
        $this->compare = $compareService;
        $this->userMatchRepository = $userMatchRepository;
        $this->ageFiltrationService = $ageFiltrationService;
        $this->budgetFiltrationService = $budgetFiltrationService;
    }

    public function filter(User $user, array $formParameters) : void
    {
        $this->deleteUserInfoAboutMatches($user);

        $users = $this->entityManager
            ->getRepository(User::class)
            ->findMatchesByCityAndGender($user->getCity(), $user->getId(), $formParameters["gender"]);


        if (!empty($users) && $formParameters['budget'] != null) {
            $users = $this->budgetFiltrationService->filterByBudget($users, $formParameters["budget"]);
        }

        if (!empty($users)) {
            $users = $this
                ->ageFiltrationService->filterByAge($users, [$formParameters["minAge"], $formParameters["maxAge"]]);
        }

        if (!empty($users)) {
            $users = $this->compare->filterByAnswers($users, $user, $formParameters['MatchPercent']);
        }

        if (!empty($users)) {
            $this->addNewMatchesToDatabase($users, $user);
        }
    }

    public function getPossibleMatch(User $user) : array
    {
        $users = $this->userMatchRepository->findMatches($user->getId());

        return $users;
    }

    public function addNewMatchesToDatabase($users, User $user) :void
    {
        $query = "INSERT INTO user_match (first_user, second_user, coeficient) VALUES ";
        $i = 1;
        foreach ($users as $oneUser) {
            if ($i === 1) {
                $query .= "('";
            } else {
                $query .= ",('";
            }
            $query .= $user->getId() . "','" . $oneUser->getId() . "',"
                . round($this->compare->coincidenceCoefficient($this->compare
                    ->getUserCoefficientAverage($user), $this->compare
                    ->getUserCoefficientAverage($oneUser)));
            $query .=")";
            $i++;
        }
        $this->userMatchRepository->query($query);
    }

    private function deleteUserInfoAboutMatches(User $user) : void
    {
        $query = "DELETE FROM user_match WHERE first_user = ";
        $query .="'";
        $query .=$user->getId();
        $query .= "'";
        $this->userMatchRepository->query($query);
    }
}
