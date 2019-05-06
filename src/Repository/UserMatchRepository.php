<?php

namespace App\Repository;

use App\Entity\UserMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMatch[]    findAll()
 * @method UserMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMatchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserMatch::class);
    }
}
