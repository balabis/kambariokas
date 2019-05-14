<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class MatchesPaginationService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    private function createQueryBuilderToGetMatchUsers($userId)
    {
        $queryBuilder = $this->em->createQueryBuilder()
            ->select('um')
            ->from('App\Entity\UserMatch', 'um')
            ->andWhere('um.firstUser = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('um.coeficient', 'DESC');

        return $queryBuilder;
    }

    private function getAdapter($userId)
    {
        $queryBuilder = $this->createQueryBuilderToGetMatchUsers($userId);
        $adapter = new DoctrineORMAdapter($queryBuilder);
        return $adapter;
    }

    public function getPagerfanta($userId)
    {
        $adapter = $this->getAdapter($userId);
        $pagerfanta = new Pagerfanta($adapter);
        return $pagerfanta;
    }

}