<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    /**
     * @Route("/matched", name="matched")
     */
    public function index()
    {
        return $this->render('match/index.html.twig', [
            'controller_name' => 'MatchController',
            'contentName' => 'Match'
        ]);
    }
}
