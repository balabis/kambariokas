<?php

namespace App\Repository;

use App\Entity\UserHobby;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserHobby|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserHobby|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserHobby[]    findAll()
 * @method UserHobby[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserHobbyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserHobby::class);
    }

    // /**
    //  * @return UserHobby[] Returns an array of UserHobby objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserHobby
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
