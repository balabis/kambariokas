<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\UserMatch;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    private $entityManager;

    private $city;

    private $compare;

    public function __construct(
        EntityManagerInterface $entityManager,
        CityService $cityService,
        UserCompareService $compareService
    ) {
        $this->entityManager = $entityManager;
        $this->city = $cityService;
        $this->compare = $compareService;
    }

    public function filter(User $user) : void
    {
        $this->deleteUserInfoAboutMatches($user);

        $users = $this->entityManager->getRepository(User::class)->findBy(['city'=>$user->getCity()]);
        $users = $this->compare->filterByAnswers($users, $user);

        $this->addNewMatchesToDatabase($users, $user);
    }

    public function getPossibleMatch(User $user) : array
    {
        $users = $this->entityManager
            ->getRepository(UserMatch::class)
            ->findBy(['firstUser' => $user->getId()]);

        return $users;
    }

    private function addNewMatchesToDatabase($users, User $user) : void
    {
        $batchSize = 20;
        $i = 0;
        foreach ($users as $oneUser) {
            if ($user->getId() !== $oneUser->getId()) {
                $match = new UserMatch();
                $match->setFirstUser($user->getId());
                $match->setSecondUser($oneUser->getId());
                $match
                    ->setCoefficient(round($this->compare->coincidenceCoefficient($this->compare
                        ->getUserCoefficientAverage($user), $this->compare
                        ->getUserCoefficientAverage($oneUser))));
                $this->entityManager->persist($match);

                if ($i / $batchSize === 1) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();
                    $i = 0;
                }
                $i+=1;
            }
        }

        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function deleteUserInfoAboutMatches(User $user) : void
    {
        $removableObjects = $this->getPossibleMatch($user);

        foreach ($removableObjects as $removableObject) {
            $this->entityManager->remove($removableObject);
        }
    }
}
