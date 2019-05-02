<?php


namespace App\Controller;

use App\Form\CitySelectionFormType;
use App\Services\CityService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CityController extends AbstractController
{

    /**
     * @Route("/city", name="city")
     */
    public function index(EntityManagerInterface $em, Request $request, CityService $service)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($service->getCityByUserEmail($this->getUser(), $em) == null) {
            $form = $this->createForm(CitySelectionFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $city = $form->getData()["ChoseYourCity"];
                $service->setUserCity($this->getUser(), $city, $em);

                return $this->redirectToRoute('match');
            }

            return $this->render('matching/city.html.twig', [
                'citySelectionForm' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('match');
        }
    }




}