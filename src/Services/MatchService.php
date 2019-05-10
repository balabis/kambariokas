<?php


namespace App\Services;

use App\Entity\City;
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

    public function filter(User $user, UserCompareService $compareService) : void
    {
        $this->deleteUserInfoAboutMatches($user);

        $users = $this->entityManager->getRepository(User::class)->findAll(); //need fix
        $users = $this->city->filterByCity($users, $user);
        $users = $this->compare->filterByAnswers($users, $user);

        $this->addNewMatchesToDatabase($users, $user, $this->compare, $compareService);
    }

    public function getPossibleMatch(User $user) : array
    {

        $users = $this->entityManager
            ->getRepository(UserMatch::class)
            ->findBy(['firstUser' => $user->getId()]);

        return $users;
    }

    private function addNewMatchesToDatabase(
        $users,
        User $user,
        UserCompareService $compare,
        UserCompareService $compareService
    ) : void {

        foreach ($users as $oneUser) {
            if ($user->getId() !== $oneUser->getId()) {
                $match = new UserMatch();
                $match->setFirstUser($user->getId());
                $match->setSecondUser($oneUser->getId());
                $match
                    ->setCoefficient(round($compareService->coincidenceCoefficient($compare
                        ->getUserCoefficientAverage($user), $compare
                        ->getUserCoefficientAverage($oneUser))));
                $this->entityManager->persist($match);
            }
        }

        $this->entityManager->flush();
    }

    private function deleteUserInfoAboutMatches(User $user) : void
    {
        $removableObjects = $this->getPossibleMatch($user);

        foreach ($removableObjects as $removableObject) {
            $this->entityManager->remove($removableObject);
        }
    }
}
