<?php

namespace App\Controller;

use App\Repository\UserMatchRepository;
use App\Services\MatchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    /**
     * @Route("/matched", name="matched")
     */
    public function index(EntityManagerInterface $entityManager, MatchService $service, UserMatchRepository $repository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $service->filter($entityManager, $this->getUser(), $repository);
        $matches = $service->getPossibleMatch($this->getUser(), $entityManager);

        return $this->render('match/index.html.twig', [
            'controller_name' => 'MatchController',
            'contentName' => 'Match',
            'matchesInfo' => $matches,

        ]);
    }
}
