<?php


namespace App\Controller;

use App\Entity\UserHobby;
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
        $userHobbies = $this->getUserHobbiesById($em, 1);
        if ($userHobbies != null) {
            $hobbies = $this->getAllHobbies($em);
            return $this->render('matching/hobbies.html.twig', [
                'hobbiesList' => $hobbies,
            ]);
        } else {
            $response = $this->forward('App\Controller\MatchingController::getResponseFromHobbies', [
            ]);
            return $response;
        }
    }

    /**
     * @param EntityManagerInterface $em
     * @return array
     */
    private function getAllHobbies(EntityManagerInterface $em) :array
    {
        $repository = $em->getRepository(Hobby::class);
        $hobbies = $repository->findAll();
        return $hobbies;
    }

    private function getUserHobbiesById(EntityManagerInterface $em, int $id) : ?array
    {
        //TODO: get specified hobbies by user id
        $repository = $em->getRepository(UserHobby::class);
        //$userHobbies = $repository->findOneBy($id);
        return null;
    }
}