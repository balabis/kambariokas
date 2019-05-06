<?php


namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{

    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
            $this->userRepository = $userRepository;
    }

    /**
     * @param $uuid
     * @return User
     */
    public function getUserByUUID($uuid): User
    {
        $user = $this->userRepository->findOneBy(['id' => $uuid]);

        return $user instanceof User ? $user : null;
    }

    /**
     * @param User $user
     * @return string|null
     */
    public function getUserAge(User $user)
    {
        $dateOfBirth = $user->getDateOfBirth();
        $today = date('Y-m-d');

        if (isset($dateOfBirth)) {
            $dateOfBirth = $dateOfBirth->format('Y-m-d');
        }

        if (isset($dateOfBirth)) {
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            return $diff->format('%y');
        } else {
            return null;
        }
    }
}