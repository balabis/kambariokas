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
            if ($oneUserCoefficient - $userCoefficientAverage < 0.5) {
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
}
