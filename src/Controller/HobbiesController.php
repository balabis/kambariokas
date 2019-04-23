<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HobbiesController extends AbstractController
{
    /**
     * @Route("/hobbies", name="hobbies")
     */
    public function index()
    {
        return $this->render('matching/hobbies.html.twig', [
            'someVariable' => 'some hobby',
        ]);
    }
}