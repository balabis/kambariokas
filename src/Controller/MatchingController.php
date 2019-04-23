<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class MatchingController extends AbstractController
{
    /**
     * @Route("/match", name="matching")
     */
    public function index(EntityManagerInterface $em)
    {
        $user = $this->getPossibleRoommates($em);
        return $this->render('matching/match.html.twig', [
            'someVariable' => $user[1]->getValue(),
        ]);
    }

    private function getPossibleRoommates(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(User::class);
        $users = $repository->findAll();
        return $users;
    }
}