<?php


namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CityService
{

    public function __construct()
    {
    }

    public function getCityByUserEmail(User $user, EntityManagerInterface $entityManager) : ?string
    {
        return $entityManager
            ->getRepository(User::class)
            ->findBy(['email' => $user->getEmail()])[0]
            ->getCity();
    }

    public function setUserCity(User $user, string $city, EntityManagerInterface $em)
    {
        $user->setCity($city);
        $em->flush();
    }

    public function filterByCity($users, User $user) :array
    {
        return array();
    }
}
