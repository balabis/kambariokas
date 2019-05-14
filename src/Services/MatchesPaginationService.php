<?php


namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use \Ramsey\Uuid\Uuid as Uuid;

class MatchesPaginationService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function createQueryBuilderToGetMatchUsers(Uuid $userId)
    {
        $queryBuilder = $this->em->createQueryBuilder()
            ->select('um')
            ->from('App\Entity\UserMatch', 'um')
            ->andWhere('um.firstUser = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('um.coeficient', 'DESC');

        return $queryBuilder;
    }

    private function getAdapter(Uuid $userId): DoctrineORMAdapter
    {
        $queryBuilder = $this->createQueryBuilderToGetMatchUsers($userId);
        $adapter = new DoctrineORMAdapter($queryBuilder);

        return $adapter;
    }

    public function getPagerfanta(Uuid $userId): Pagerfanta
    {
        $adapter = $this->getAdapter($userId);
        $pagerfanta = new Pagerfanta($adapter);

        return $pagerfanta;
    }
}
