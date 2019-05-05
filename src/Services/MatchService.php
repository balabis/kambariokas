<?php


namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    public function __construct()
    {
    }

    public function filter(EntityManagerInterface $entityManager, User $user) : array
    {
        $city = new CityService();
        $flat = new FlatService();

        $users = $entityManager->getRepository(User::class)->findAll();
        $users = $this->removeUserFromHisPossibleMatchArray($users, $user);
        $users = $city->filterByCity($users, $user);
        $users = $flat->filterByFlat($users, $user);
        return $users;
    }

    private function removeUserFromHisPossibleMatchArray($users, User $user) : array
    {
        return \array_diff($users, [$user]);
    }

    public function getPossibleMatch(User $user, EntityManagerInterface $entityManager) : array
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findBy(['city' => $user->getCity()]);

        $usersEmail = array();
        $i = 0;

        foreach ($users as $oneUser) {
            if ($oneUser->getEmail() !== $user->getEmail()) {
                $usersEmail[$i++] = $oneUser->getEmail();
            }
        }

        return $usersEmail;
    }
}
