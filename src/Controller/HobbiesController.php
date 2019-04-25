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
           // $hobbies = $this->getAllHobbies($em);
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
     * @return array
     */
    private function getAllHobbies(EntityManagerInterface $em) :array
    {
        $repository = $em->getRepository(Hobby::class);
        return $repository->findAll();
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
    public function addHobbiesForUsers(EntityManagerInterface $em)
    {



       // $userHobby = new UserHobby();
      //  $userHobby->setUserId(random_int(1, 100));
       // $userHobby->setHobbyId(2);
       // $em->persist($userHobby);
       // $em->flush();
        return new Response('it works!');
    }
}