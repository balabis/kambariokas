<?php


namespace App\Service;

use App\Entity\User;
use App\Service\UuidEncoderService;
use App\Repository\UserRepository;

class UserService
{

    private $encoder;
    private $userRepository;

    public function __construct(UuidEncoderService $encoder, UserRepository $userRepository)
    {
            $this->encoder = $encoder;
            $this->userRepository = $userRepository;
    }

    public function getUserByUUID($id): User
    {
        $userUUID = $this->encoder->decode($id);
        $user = $this->userRepository->findOneBy(['id' => $userUUID]);

        return $user instanceof User ? $user : null;
    }

}