<?php

namespace App\Services;

use App\Entity\QuestionnaireScore;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserCompareService
{
    private $entityManager;

    private $minCoefficient;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->minCoefficient = 50;
    }

    public function filterByAnswers($users, User $user) : array
    {
        $selectedUsers = array();
        $userCoefficientAverage = $this->getUserCoefficientAverage($user);

        foreach ($users as $oneUser) {
            $oneUserCoefficient = $this->getUserCoefficientAverage($oneUser);

            if ($this->coincidenceCoefficient($userCoefficientAverage, $oneUserCoefficient) > $this->minCoefficient) {
                $selectedUsers[] = $oneUser;
            }
        }

        return $selectedUsers;
    }

    public function getUserCoefficientAverage(User $user) : float
    {
        $questionScores = $this->entityManager
            ->getRepository(QuestionnaireScore::class)
            ->findBy(['userId' => $user->getId()]);

        return ($questionScores[0]->getCleanliness() + $questionScores[0]->getSociability()
            + $questionScores[0]->getSocialOpenness() + $questionScores[0]->getSocialFlexibility())/4;
    }

    public function coincidenceCoefficient(float $userScore, float $otherUserScore) : float
    {
        $score = $userScore - $otherUserScore;

        if ($score < 0) {
            $score *= -1;
        }

        $scoreUsingPersent = $score * 100 / $userScore;

        return 100 - $scoreUsingPersent;
    }
}
