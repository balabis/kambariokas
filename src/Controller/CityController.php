<?php


namespace App\Controller;

use App\Form\CitySelectionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CityController extends AbstractController
{

    /**
     * @Route("/city")
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(CitySelectionFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            var_dump($form->getData());
        }


        return $this->render('matching/hobbies.html.twig', [
            'hobbiesForm' => $form->createView()
        ]);
    }
}