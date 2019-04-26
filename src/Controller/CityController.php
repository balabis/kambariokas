<?php


namespace App\Controller;

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
        $form = $this->createForm(CitySelectionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->setUserCity($this->getUser(), $form->getData()["ChoseYourCity"], $em);
            //return $this->forward()
        }

        return $this->render('matching/hobbies.html.twig', [
            'hobbiesForm' => $form->createView()
        ]);
    }

    public function setUserCity(User $user, string $city, EntityManagerInterface $em)
    {
        $user->setCityCode($city);
        $em->flush();
    }
}