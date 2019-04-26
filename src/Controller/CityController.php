<?php


namespace App\Controller;

use App\Entity\City;
use App\Entity\User;
use App\Form\CitySelectionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class CityController extends AbstractController
{

    /**
     * @Route("/city", name="city")
     */
    public function index(EntityManagerInterface $em, Request $request, AuthenticationUtils $authenticationUtils)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->getUserCityById($this->getUser()) == null) {
            $form = $this->createForm(CitySelectionFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $city = $form->getData()["ChoseYourCity"];
                $this->setUserCity($this->getUser(), $city, $em);
                return $this->forward('App\Controller\MatchingController::getResponseFromHobbies', [
                    'city' => $city
                ]);
            }

            return $this->render('matching/hobbies.html.twig', [
                'hobbiesForm' => $form->createView()
            ]);
        } else {
            return $this->forward('App\Controller\MatchingController::getResponseFromHobbies', [
                'city' => $this->getUserCityById($this->getUser())
            ]);
        }
    }

    public function setUserCity(User $user, string $city, EntityManagerInterface $em)
    {
        $user->setCityCode($city);
        $em->flush();
    }

    public function getUserCityById(User $user) : string
    {
        return $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['email' => $user->getEmail()])[0]
            ->getCityCode();
    }
}