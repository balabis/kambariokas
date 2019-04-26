<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\City;
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
            'cityName' => $this->getCityNameById($city),
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

    private function getCityNameById($city) : string
    {
        return $this->getDoctrine()
            ->getRepository(City::class)
            ->find($city)
            ->getTitle();
    }
}