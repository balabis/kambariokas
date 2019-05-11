<?php


namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CityService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getCityByUserEmail(User $user) : ?string
    {
        return $this
            ->entityManager
            ->getRepository(User::class)
            ->findBy(['email' => $user->getEmail()])[0]
            ->getCity();
    }

    public function setUserCity(User $user, string $city)
    {
        $user->setCity($city);
        $this->entityManager->flush();
    }

    public function filterByCity($users, User $user) : array
    {
        $newUsersArray = [];

        foreach ($users as $oneUser) {
            if ($user->getCity() === $oneUser->getCity()) {
                $newUsersArray[] = $oneUser;
            }
        }
        return $newUsersArray;
    }
}
