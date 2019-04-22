<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{
    /**
     * @Route("/match", name="matching")
     */
    public function index()
    {
        return $this->render('matching/match.html.twig', [
            'someVariable' => 'NFQ Akademija',
        ]);
    }
}