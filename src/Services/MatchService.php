<?php


namespace App\Services;

use App\Entity\User;
use App\Entity\UserMatch;
use App\Repository\UserMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    public function __construct()
    {
    }

    public function filter(EntityManagerInterface $entityManager, User $user, UserMatchRepository $repository) : void
    {
        $city = new CityService();
        $compare = new UserCompareService();

        $this->deleteUserInfoAboutMatches($user, $entityManager);

        $users = $entityManager->getRepository(User::class)->findAll();
        $users = $city->filterByCity($users, $user);

        $users = $compare->filterByAnswers($users, $user, $entityManager);
        $this->addNewMatchesToDatabase($users, $user, $entityManager, $compare);
    }

    public function getPossibleMatch(User $user, EntityManagerInterface $entityManager) : array
    {
        $users = $entityManager
            ->getRepository(UserMatch::class)
            ->findBy(['firstUser' => $user->getId()]);

        return $users;
    }

    private function addNewMatchesToDatabase(
        $users,
        User $user,
        EntityManagerInterface $entityManager,
        UserCompareService $compare
    ) : void {
        foreach ($users as $oneUser) {
            if ($user->getId() !== $oneUser->getId()) {
                $match = new UserMatch();
                $match->setFirstUser($user->getId());
                $match->setSecondUser($oneUser->getId());
                $match
                    ->setCoefficient(round($this->coincidenceCoefficient($compare
                        ->getUserCoefficientAverage($entityManager, $user), $compare
                        ->getUserCoefficientAverage($entityManager, $oneUser))));
                $entityManager->persist($match);
            }
        }
        $entityManager->flush();
    }

    private function deleteUserInfoAboutMatches(User $user, EntityManagerInterface $entityManager) : void
    {
        $removableObjects = $this->getPossibleMatch($user, $entityManager);

        foreach ($removableObjects as $removableObject) {
            $entityManager->remove($removableObject);
        }
    }

    private function coincidenceCoefficient(float $userScore, float $otherUserScore) : float
    {
        $score = $userScore - $otherUserScore;
        if ($score < 0) {
            $score *= -1;
        }
        $scoreUsingPersent = $score * 100 / $userScore;
        return 100 - $scoreUsingPersent;
    }
}
