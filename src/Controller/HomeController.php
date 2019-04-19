<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {

        $entityManager = $this->getDoctrine()->getManager();
//
        $user = new User();
        $user->setCityCode("KAUNAS");
        $user->setDateOfBirth(new \DateTime());
        $user->setEmail("test@testgmail.com");
        $user->setFullName("Testas Testuotojas");
        $user->setGender("Male");
//
        $entityManager->persist($user);
//
        $entityManager->flush();

        return $this->render('home/index.html.twig', [
            'someVariable' => 'NFQ Akademija',
        ]);
    }
}
