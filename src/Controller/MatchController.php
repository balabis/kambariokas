<?php

namespace App\Controller;

use App\Command\UsersGenerator;
use App\Entity\UserMatch;
use App\Form\MatchFilterFormType;
use App\Repository\UserMatchRepository;
use App\Services\MatchesPaginationService;
use App\Services\MatchService;
use Doctrine\ORM\EntityManagerInterface;
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
        Request $request,
        UsersGenerator $generator,
        EntityManagerInterface $entityManager
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

    //    $generator->generateUsers(0);

        $form = $this->createForm(MatchFilterFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()->getIsActive()) {
                $service->filter($this->getUser(), $form->getData());
            }
        }

        $matches = $service->getPossibleMatch($this->getUser());
        var_dump(count($matches));

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
