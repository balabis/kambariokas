<?php

namespace App\Controller;

use App\Entity\City;
use App\Services\MatchService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{
    /**
     * @Route("/match", name="match")
     */
    public function index(EntityManagerInterface $entityManager, MatchService $service)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $getMatchEmails = $service->getPossibleMatch($this->getUser(), $entityManager);

        return $this->render('matching/match.html.twig', [
            'cityName' => $entityManager
                ->getRepository(City::class)
                ->find($this->getUser()->getCityCode())
                ->getTitle(),
            'emails' => $getMatchEmails
        ]);
    }
}