<?php


namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hobby;

class HobbiesController extends AbstractController
{
    /**
     * @Route("/hobbies", name="hobbies")
     */
    public function index(EntityManagerInterface $em)
    {
        $hobbies = $this->getAllHobbies($em);
        return $this->render('matching/hobbies.html.twig', [
            'hobbiesList' => $hobbies,
        ]);
    }

    /**
     * @param EntityManagerInterface $em
     * @return array
     */
    public function getAllHobbies(EntityManagerInterface $em) :array
    {
        $repository = $em->getRepository(Hobby::class);
        $hobbies = $repository->findAll();
        return $hobbies;
    }
}