<?php


namespace App\Services;

use App\Entity\User;
use App\Entity\UserMatch;
use App\Repository\UserMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    public function __construct()
    {
    }

    public function filter(EntityManagerInterface $entityManager, User $user, UserMatchRepository $repository) : void
    {
        $city = new CityService();
        $flat = new FlatService();
        $this->deleteUserInfoAboutMatches($user, $repository);
        $users = $entityManager->getRepository(User::class)->findAll();
        $users = $city->filterByCity($users, $user);
        $users = $flat->filterByFlat($users, $user);
        $this->addNewMatchesToDatabase($users, $user, $entityManager);
    }

    public function getPossibleMatch(User $user, EntityManagerInterface $entityManager) : array
    {
        $users = $entityManager
            ->getRepository(UserMatch::class)
            ->findBy(['firstUser' => $user->getId()]);

        return $users;
    }

    private function addNewMatchesToDatabase($users, User $user, EntityManagerInterface $entityManager) : void
    {
        foreach ($users as $oneUser) {
            if ($user->getId() !== $oneUser->getId()) {
                $match = new UserMatch();
                $match->setFirstUser($user->getId());
                $match->setSecondUser($oneUser->getId());
                $match->setCoefficient(0.01);
                $entityManager->persist($match);
            }
        }
        $entityManager->flush();
    }

    private function deleteUserInfoAboutMatches(User $user, UserMatchRepository $repository) : void
    {
        $repository->deleteUsersMatch($user);
    }
}
