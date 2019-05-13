<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\UserMatch;
use App\Repository\UserMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    private $entityManager;

    private $city;

    private $compare;

    private $userMatchRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CityService $cityService,
        UserCompareService $compareService,
        UserMatchRepository $userMatchRepository
    ) {
        $this->entityManager = $entityManager;
        $this->city = $cityService;
        $this->compare = $compareService;
        $this->userMatchRepository = $userMatchRepository;
    }

    public function filter(User $user) : void
    {
        $this->deleteUserInfoAboutMatches($user);

        $users = $this->entityManager->getRepository(User::class)->findBy(['city'=>$user->getCity()]);
        $users = $this->compare->filterByAnswers($users, $user);

        $this->addNewMatchesToDatabase($users, $user);
    }

    public function getPossibleMatch(User $user) : array
    {
        $users = $this->entityManager
            ->getRepository(UserMatch::class)
            ->findBy(['firstUser' => $user->getId()]);

        return $users;
    }

    private function addNewMatchesToDatabase($users, User $user) :void
    {
        $query = "INSERT INTO symfony.user_match (first_user, second_user, coeficient) VALUES ";
        $i = 1;

        foreach ($users as $oneUser) {
            if ($user->getId() !== $oneUser->getId()) {
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

            if ($i === count($users)-1) {
                $query .= ";";
            }
        }

        $this->userMatchRepository->query($query);
    }

    private function deleteUserInfoAboutMatches(User $user) : void
    {
        $query = "DELETE FROM symfony.user_match WHERE first_user = ";
        $query .="'";
        $query .=$user->getId();
        $query .= "'";
        $this->userMatchRepository->query($query);
    }
}
