<?php

namespace App\Controller;

use App\Repository\UserMatchRepository;
use App\Services\MatchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{
    /**
     * @Route("/match", name="match")
     */
    public function index(EntityManagerInterface $entityManager, MatchService $service, UserMatchRepository $repository)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $service->filter($entityManager, $this->getUser(), $repository);
        $getMatchEmails = $service->getPossibleMatch($this->getUser(), $entityManager);

        return $this->render('matching/match.html.twig', [
            'cityName' => $this->getUser()->getCity(),
            'emails' => $getMatchEmails,
            'length' => count($getMatchEmails)
        ]);
    }
}
