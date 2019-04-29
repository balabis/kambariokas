<?php


namespace App\Services;

use App\Entity\User;
use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{

    public function __construct()
    {
    }

    public function getPossibleMatch(User $user, EntityManagerInterface $entityManager) : array
    {
        $users = $entityManager
            ->getRepository(User::class)
            ->findBy(['cityCode' => $user->getCityCode()]);
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