<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class PaginationService
{
    private $em;

    private $pagerfanta;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->pagerfanta = new Pagerfanta($this->getAdapter());
        $this->pagerfanta->setMaxPerPage(8);
    }

    private function createQueryBuilder()
    {
        $queryBuilder = $this->em->createQueryBuilder()
            ->select('m')
            ->from('App\Entity\User', 'm');

        return $queryBuilder;
    }

    private function getAdapter()
    {
        $queryBuilder = $this->createQueryBuilder();
        $adapter = new DoctrineORMAdapter($queryBuilder);
        return $adapter;
    }

    public function getPagerfanta()
    {
        return $this->pagerfanta;
    }

}