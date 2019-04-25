<?php


namespace App\Controller;

use App\Entity\UserHobby;
use App\Form\HobbiesSelectionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Hobby;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class HobbiesController extends AbstractController
{
    /**
     * @Route("/match", name="matching")
     */
    public function index(EntityManagerInterface $em)
    {
        if ($this->checkIfUserHaveHobbies($em, 103) == null) {
            $form = $this->createForm(HobbiesSelectionFormType::class);
            return $this->render('matching/hobbies.html.twig', [
                'hobbiesForm' => $form->createView()
            ]);
        } else {
            $response = $this->forward('App\Controller\MatchingController::getResponseFromHobbies', [
            ]);
            return $response;
        }
    }

    /**
     * @param EntityManagerInterface $em
     * @param int $id
     * @return bool
     */
    private function checkIfUserHaveHobbies(EntityManagerInterface $em, int $id) : bool
    {
        $repository = $em->getRepository(UserHobby::class);
        if ($repository->findOneBy(['userId' => $id]) != null) {
            return true;
        }
        return false;
    }

    /**
     * @Route("/hobbies", name="addHobbies")
     */
    public function addHobbiesForUsers()
    {
        return new Response('it works!');
    }
}