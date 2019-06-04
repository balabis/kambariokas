<?php

namespace App\Command;

use App\Entity\QuestionnaireScore;
use App\Entity\User;
use App\Services\MatchService;
use Doctrine\ORM\EntityManagerInterface;

class UsersGenerator
{
    private $entityManager;

    private $matchController;

    public function __construct(EntityManagerInterface $entityManager, MatchService $service)
    {
        $this->entityManager = $entityManager;
        $this->matchController = $service;
    }

    public function generateUsers(int $userCount) : void
    {
        $cities = ['Vilnius', 'Kaunas'];
        $budgets = ['iki 50eur/mėn', 'iki 100eur/mėn', 'iki 200eur/mėn', '> 200eur/mėn', ''];
        $genders = ['male','female'];
          $activity = [true,false];
        for ($i = 0; $i < $userCount; $i++) {
            $user = new User();
            $user->setCity($cities[rand(0, 1)]);
            $user->setFullName('uName'. $i);
            $user->setEmail('email'.$i.'@gmail.com');
            $user->setPassword('aaa');
            $user->setProfilePicture('build/default.png');
            $user->setBudget($budgets[rand(0, 3)]);
            $user->setUsername("uName".$i);
            $date = rand(1950, 2019)."-05-11";
            $user->setDateOfBirth(new \DateTime($date));
            $user->setGender($genders[rand(0, 1)]);
            $user->setIsActive($activity[rand(0, 1)]);
            $this->entityManager->persist($user);
        }

        $this->entityManager->flush();

        $this->generateAnswers();
        $this->generateUserMatch();
    }

    public function generateAnswers() : void
    {
        $usersId = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($usersId as $user) {
            $answer = new QuestionnaireScore();
            $answer->setUserId($user->getId());
            $answer->setCleanliness(5*(rand(0, 100)/100));
            $answer->setSociability(5*(rand(0, 100)/100));
            $answer->setSocialFlexibility(5*(rand(0, 100)/100));
            $answer->setSocialOpenness(5*(rand(0, 100)/100));
            $this->entityManager->persist($answer);
        }

        $this->entityManager->flush();
    }

    private function generateUserMatch() : void
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        
        foreach ($users as $user) {
            $this->matchController->addNewMatchesToDatabase($users, $user);
        }
    }
}
