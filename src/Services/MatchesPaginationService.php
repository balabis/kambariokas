<?php


namespace App\Services;


use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class MatchesPaginationService
{

    private function getAdapter($array)
    {
        $adapter = new ArrayAdapter($array);
        return $adapter;
    }

    public function getPagerfanta($array)
    {
        $adapter = $this->getAdapter($array);
        $pagerfanta = new Pagerfanta($adapter);
        return $pagerfanta;
    }

}