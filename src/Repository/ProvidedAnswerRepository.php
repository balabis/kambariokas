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
}
