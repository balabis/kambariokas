<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function findMatchesByCityAndGender($city, $userId, $gender)
    {
        $query =  $this->createQueryBuilder('m')
            ->andWhere('m.city = :city')
            ->andWhere('m.id != :id');
        if ($gender != "default") {
            $query
                ->andWhere('m.gender = :gender')
                ->setParameters(['city' => $city, 'id' => $userId, 'gender' => $gender]);
        } else {
            $query->setParameters(['city' => $city, 'id' => $userId]);
        }
        return $query
            ->getQuery()
            ->getResult();
    }
}
