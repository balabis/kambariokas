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

    public function filterByAnswers(
        $users,
        User $user,
        int $filterCoefficient
    ): array {
        $this->minCoefficient = $filterCoefficient;
        $selectedUsers = [];
        foreach ($users as $oneUser) {
            if ($oneUser->getId() !== $user->getId()) {
                $matchPercent = $this->getMatchPercent($user, $oneUser);
                if ($matchPercent >= $this->minCoefficient) {
                    $selectedUsers[] = $oneUser;
                }
            }
        }

        return $selectedUsers;
    }

    public function getMatchPercent($currentUser, $compareUser)
    {
        $currentUserQuestionnaireScores = $this->entityManager
            ->getRepository(QuestionnaireScore::class)
            ->findOneBy(['userId' => $currentUser->getId()]);
        $compareUserQuestionnaireScores = $this->entityManager
            ->getRepository(QuestionnaireScore::class)
            ->findOneBy(['userId' => $compareUser->getId()]);

        $cleanlinessMatch =
            abs($currentUserQuestionnaireScores->getCleanliness() -
                $compareUserQuestionnaireScores->getCleanliness());
        $sociabilityMatch =
            abs($currentUserQuestionnaireScores->getSociability() -
                $compareUserQuestionnaireScores->getSociability());
        $socialOpennessMatch =
            abs($currentUserQuestionnaireScores->getSocialOpenness() -
                $compareUserQuestionnaireScores->getSocialOpenness());
        $socialFlexibilityMatch =
            abs($currentUserQuestionnaireScores->getSocialFlexibility() -
                $compareUserQuestionnaireScores->getSocialFlexibility());

        $matchPercent =
            (1 - (($cleanlinessMatch + $sociabilityMatch + $socialOpennessMatch + $socialFlexibilityMatch) / 4)) * 100;

        return $matchPercent;
    }
}
