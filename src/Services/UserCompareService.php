<?php


namespace App\Services;

use App\Entity\QuestionnaireScore;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserCompareService
{

    public function filterByAnswers($users, User $user, EntityManagerInterface $entityManager) : array
    {
        $selectedUsers = array();
        $userCoefficientAverage = $this->getUserCoefficientAverage($entityManager, $user);

        foreach ($users as $oneUser) {
            $oneUserCoefficient = $this->getUserCoefficientAverage($entityManager, $oneUser);

            if ($this->coincidenceCoefficient($userCoefficientAverage, $oneUserCoefficient) > 50) {
                $selectedUsers[] = $oneUser;
            }
        }

        return $selectedUsers;
    }

    public function getUserCoefficientAverage(EntityManagerInterface $entityManager, User $user) : float
    {
        $questionScores = $entityManager
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
