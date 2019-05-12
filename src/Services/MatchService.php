<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\UserMatch;
use App\Generator\UsersGenerator;
use Doctrine\ORM\EntityManagerInterface;

class MatchService
{
    private $entityManager;

    private $city;

    private $compare;

    private $generator;

    public function __construct(
        EntityManagerInterface $entityManager,
        CityService $cityService,
        UserCompareService $compareService,
        UsersGenerator $usersGenerator
    ) {
        $this->entityManager = $entityManager;
        $this->city = $cityService;
        $this->compare = $compareService;
        $this->generator = $usersGenerator;
    }

    public function filter(User $user) : void
    {
        $time_start = microtime(true);

        $this->deleteUserInfoAboutMatches($user);
        $time_end = microtime(true);
        var_dump(($time_end - $time_start));

        $time_start = microtime(true);
        $users = $this->entityManager->getRepository(User::class)->findBy(['city'=>$user->getCity()]);
        $users = $this->compare->filterByAnswers($users, $user);
        $time_end = microtime(true);
        var_dump(($time_end - $time_start));

        $time_start = microtime(true);
        $this->addNewMatchesToDatabase($users, $user);
        $time_end = microtime(true);

        var_dump(($time_end - $time_start));
    }

    public function getPossibleMatch(User $user) : array
    {
        $users = $this->entityManager
            ->getRepository(UserMatch::class)
            ->findBy(['firstUser' => $user->getId()]);

        return $users;
    }

    private function addNewMatchesToDatabase($users, User $user) :void
    {
        $query = "INSERT INTO symfony.user_match (first_user, second_user, coeficient) VALUES ";
        $i = 1;
        foreach ($users as $oneUser) {
            if ($user->getId() !== $oneUser->getId()) {
                if ($i === 1) {
                    $query .= "('";
                } else {
                    $query .= ",('";
                }

                $query .= $user->getId() . "','" . $oneUser->getId() . "',"
                    . round($this->compare->coincidenceCoefficient($this->compare
                        ->getUserCoefficientAverage($user), $this->compare
                        ->getUserCoefficientAverage($oneUser)));
                $query .=")";
                $i++;
            }

            if ($i === count($users)-1) {
                $query .= ";";
            }
        }
        $this->insertNewDate($query);
    }

    private function insertNewDate(string $query) : void
    {
        $statement = $this->entityManager->getConnection()->prepare($query);
        $statement->execute();
    }

    private function deleteUserInfoAboutMatches(User $user) : void
    {
        $query = "DELETE FROM symfony.user_match WHERE first_user = ";
        $query .="'";
        $query .=$user->getId();
        $query .= "'";
        $this->insertNewDate($query);

    }
}
