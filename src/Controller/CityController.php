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
    public function index(Request $request, CityService $service)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($service->getCityByUserEmail($this->getUser()) == null) {
            $form = $this->createForm(CitySelectionFormType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $city = $form->getData()["ChoseYourCity"];
                $service->setUserCity($this->getUser(), $city);

                return $this->redirectToRoute('matched');
            }

            return $this->render('matching/city.html.twig', [
                'citySelectionForm' => $form->createView()
            ]);
        } else {
            return $this->redirectToRoute('matched');
        }
    }
}
