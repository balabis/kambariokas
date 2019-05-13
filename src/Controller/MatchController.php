<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\PaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrap4View;
use App\Services\MatchService;
use App\Services\UserCompareService;
use App\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
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

    public function index(
        EntityManagerInterface $entityManager,
        MatchService $service,
        UserService $userService,
        UserCompareService $compareService
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $service->filter($this->getUser());

        $matches = $service->getPossibleMatch($this->getUser());
        $usersName = $userService->getAllUsersNamesByUUID($matches);

        return $this->render('match/index.html.twig', [
            'pagerfanta' => $pagerfanta,
            'contentName' => 'Match',
            'matchesInfo' => $matches,
            'usersName' => $usersName,
            'userCount'=> (count($matches) - 1)
        ]);
    }
}
