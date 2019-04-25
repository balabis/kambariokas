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
    public function index(EntityManagerInterface $em, Request $request)
    {
        $testUserId = 105;
        if ($this->checkIfUserHaveHobbies($em, $testUserId) == null) {
           $response = $this->addHobbiesForUsers($request, $testUserId);
        } else {
            $response = $this->forward('App\Controller\MatchingController::getResponseFromHobbies', [
            ]);

        }
        return $response;
    }

    private function checkIfUserHaveHobbies(EntityManagerInterface $em, int $id) : bool
    {
        $repository = $em->getRepository(UserHobby::class);
        if ($repository->findOneBy(['userId' => $id]) != null) {
            return true;
        }
        return false;
    }

    public function addHobbiesForUsers(Request $request, int $testUserId)
    {
        $form = $this->createForm(HobbiesSelectionFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            var_dump($form->getData());
        }


        return $this->render('matching/hobbies.html.twig', [
            'hobbiesForm' => $form->createView()
        ]);
    }
}