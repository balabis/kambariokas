<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    /**
     * @Route("/matched", name="matched")
     */
    public function index(PaginationService $ps, Request $request)
    {
        $pagerfanta = $ps->getPagerfanta();
        $pagerfanta->setCurrentPage($request->query->get('page', 1));

        return $this->render('match/index.html.twig', [
            'pagerfanta' => $pagerfanta,
        ]);
    }
}
