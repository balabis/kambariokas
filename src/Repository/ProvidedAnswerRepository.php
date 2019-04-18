<?php

namespace App\Repository;

use App\Entity\ProvidedAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProvidedAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProvidedAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProvidedAnswer[]    findAll()
 * @method ProvidedAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProvidedAnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProvidedAnswer::class);
    }

    // /**
    //  * @return ProvidedAnswer[] Returns an array of ProvidedAnswer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProvidedAnswer
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
