<?php

namespace App\Controller;

use App\Form\MatchFilterFormType;
use App\Services\MatchesPaginationService;
use App\Services\MatchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormTypeInterface;

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
        $matchesPagination = $ps->getPagerfanta($matches);
        $matchesPagination->setMaxPerPage(8);
        $matchesPagination->setCurrentPage($request->query->get('page', 1));

        $form = $this->createForm(MatchFilterFormType::class);
        $form->handleRequest($request);

        return $this->render('match/index.html.twig', [
            'matches' => $matchesPagination,
            'contentName' => 'Match',
            'filterForm' => $form->createView()
        ]);
    }
}
