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
            ->findBy(['firstUser' => $user->getId()], ['coeficient'=>'DESC']);

        return $users;
    }

    private function addNewMatchesToDatabase($users, User $user) :void
    {
        foreach ($users as $oneUser) {
            if ($user->getId() !== $oneUser->getId()) {
                $userMatch = new UserMatch();
                $userMatch->setFirstUser($user->getId());
                $userMatch->setSecondUser($oneUser->getId());
                $coefficient = round($this->compare->coincidenceCoefficient(
                    $this->compare->getUserCoefficientAverage($user),
                    $this->compare->getUserCoefficientAverage($oneUser)
                ));
                $userMatch->setCoefficient($coefficient);
                $userMatch->setMatchedUser($oneUser);
                $this->entityManager->persist($userMatch);
            }
        }
        $this->entityManager->flush();
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
