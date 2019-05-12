<?php

namespace App\Generator;

use App\Entity\QuestionnaireScore;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UsersGenerator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generateUsers(int $userCount) : void
    {
        $cities = ['Vilnius', 'Kaunas'];
        for ($i = 0; $i < $userCount; $i++) {
            $user = new User();
            $user->setCity($cities[rand(0, 1)]);
            $user->setFullName('uName'. $i);
            $user->setEmail('email'.$i.'@gmail.com');
            $user->setPassword('aaa');
            $user->setProfilePicture('uploads/profile_pictures/default/default.png');
            $this->entityManager->persist($user);
        }
        $this->entityManager->flush();

        $this->generateAnswsers();
    }

    private function generateAnswsers() : void
    {
        $usersId = $this->entityManager->getRepository(User::class)->findAll();
        foreach ($usersId as $user) {
            $answer = new QuestionnaireScore();
            $answer->setUserId($user->getId());
            $answer->setCleanliness(2+(rand(0, 100)/100));
            $answer->setSociability(2+(rand(0, 100)/100));
            $answer->setSocialFlexibility(2+(rand(0, 100)/100));
            $answer->setSocialOpenness(2+(rand(0, 100)/100));
            $this->entityManager->persist($answer);
        }
        $this->entityManager->flush();
    }

}