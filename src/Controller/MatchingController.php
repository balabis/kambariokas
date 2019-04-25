<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class MatchingController extends AbstractController
{
    public function getResponseFromHobbies()
    {
        return $this->render('matching/match.html.twig', [
            'someVariable' => 'userio match puslapis',
        ]);
    }
}