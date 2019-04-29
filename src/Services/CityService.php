<?php


namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CityService
{

    public function __construct()
    {
    }

    public function getCityCodeByUserEmail(User $user, EntityManagerInterface $entityManager) : ?string
    {
        return $entityManager
            ->getRepository(User::class)
            ->findBy(['email' => $user->getEmail()])[0]
            ->getCityCode();
    }

    public function setUserCity(User $user, string $city, EntityManagerInterface $em)
    {
        $user->setCityCode($city);
        $em->flush();
    }
}