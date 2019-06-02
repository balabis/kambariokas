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

    public function filterByAnswers($users, User $user, int $filterCoefficient): array
    {
        $this->minCoefficient = $filterCoefficient;

        $selectedUsers = [];
        $userCoefficientAverage = $this->getUserCoefficientAverage($user);

        if (!empty($userCoefficientAverage)) {
            foreach ($users as $oneUser) {
                $oneUserCoefficient =
                    $this->getUserCoefficientAverage($oneUser);

                if (!empty($oneUserCoefficient)) {
                    if ($this->coincidenceCoefficient(
                        $userCoefficientAverage,
                        $oneUserCoefficient
                    ) >= $this->minCoefficient) {
                        $selectedUsers[] = $oneUser;
                    }
                }
            }
        }

        return $selectedUsers;
    }

    public function getUserCoefficientAverage(User $user): ?float
    {
        $questionScores = $this->entityManager
            ->getRepository(QuestionnaireScore::class)
            ->findOneBy(['userId' => $user->getId()]);

        if (!empty($questionScores)) {
            return ($questionScores->getCleanliness() + $questionScores->getSociability()
                    + $questionScores->getSocialOpenness() + $questionScores->getSocialFlexibility()) / 4;
        }

        return null;
    }

    public function coincidenceCoefficient(float $userScore, float $otherUserScore): float
    {
        $score = $userScore - $otherUserScore;

        if ($score < 0) {
            $score *= -1;
        }

        $scoreUsingPersent = ($score * 100)/5;

        return 100 - $scoreUsingPersent;
    }
}
