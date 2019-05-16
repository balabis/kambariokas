<?php


namespace App\Services;

use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;

class MatchesPaginationService
{
    private function getAdapter(array $matches): ArrayAdapter
    {
        $adapter = new ArrayAdapter($matches);

        return $adapter;
    }

    public function getPagerfanta(array $matches): Pagerfanta
    {
        $adapter = $this->getAdapter($matches);

        return new Pagerfanta($adapter);
    }
}
