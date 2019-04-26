<?php

namespace App\Controller;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MatchingController extends AbstractController
{
    /**
     * @Route("/match", name="match")
     */
    public function getResponseFromHobbies($city, EntityManagerInterface $entityManager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $emails = $this->getPossibleMatch($city, $entityManager);
        return $this->render('matching/match.html.twig', [
            'someVariable' => $city,
            'emails' => $emails
        ]);
    }

    private function getPossibleMatch($city, EntityManagerInterface $entityManager) :array
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['cityCode' => $city]);
        $usersEmail = array();
        $i = 0;
        foreach ($users as $user) {
            if ($user->getEmail() !== $this->getUser()->getEmail()) {
                $usersEmail[$i++] = $user->getEmail();
            }
        }
        return $usersEmail;
    }
}