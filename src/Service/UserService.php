<?php


namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
            $this->userRepository = $userRepository;
    }

    public function getUserByUUID($uuid): User
    {
        $user = $this->userRepository->findOneBy(['id' => $uuid]);

        return $user instanceof User ? $user : null;
    }

}