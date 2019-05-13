<?php

namespace App\Controller;


use App\Entity\User;
use App\Services\MatchesPaginationService;
use App\Services\MatchService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    /**
     * @Route("/matched", name="matched")
     */
    public function index(
        MatchService $service,
        MatchesPaginationService $ps,
        Request $request
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $service->filter($this->getUser());

        $matches = $service->getPossibleMatch($this->getUser());
        $pagerfanta = $ps->getPagerfanta($matches);
        $pagerfanta->setMaxPerPage(8);
        $pagerfanta->setCurrentPage($request->query->get('page', 1));

        return $this->render('match/index.html.twig', [
            'pagerfanta' => $pagerfanta,
            'contentName' => 'Match',
            'matchesInfo' => $matches,
        ]);
    }
}
