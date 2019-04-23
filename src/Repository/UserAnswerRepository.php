<?php

namespace App\Repository;

use App\Entity\UserAnswer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserAnswer|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAnswer|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAnswer[]    findAll()
 * @method UserAnswer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserAnswer::class);
    }
}
