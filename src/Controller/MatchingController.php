<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class MatchingController extends AbstractController
{

    private function getPossibleRoommates(EntityManagerInterface $em)
    {
        $repository = $em->getRepository(User::class);
        $users = $repository->findAll();
        return $users;
    }

    public function getResponseFromHobbies()
    {
        return $this->render('matching/match.html.twig', [
            'someVariable' => 'useris turi hobiu',
        ]);
    }
}