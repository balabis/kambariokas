<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchController extends AbstractController
{
    /**
     * @Route("/matched", name="matched")
     */
    public function index(EntityManagerInterface $em)
    {
        $userRepository = $em->getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('match/index.html.twig', [
            'users' => $users,
        ]);
    }
}
