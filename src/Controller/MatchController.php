<?php

namespace App\Controller;

use App\Form\MatchFilterFormType;
use App\Services\MatchesPaginationService;
use App\Services\MatchService;
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
        $matches = [];
        if ($this->getUser()->getIsActive()) {
            $service->addMatchWithoutFiltration($this->getUser());
            $matches = $service->getPossibleMatch($this->getUser());
        }
        $form = $this->createForm(MatchFilterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()->getIsActive()) {
                $matches = $service->filter($matches, $form->getData());
            }
        }





        $matchesPagination = $ps->getPagerfanta($matches);
        $matchesPagination->setMaxPerPage(8);
        $matchesPagination->setCurrentPage($request->query->get('page', 1));

        return $this->render('match/index.html.twig', [
            'matches' => $matchesPagination,
            'contentName' => 'Match',
            'filterForm' => $form->createView()
        ]);
    }
}
