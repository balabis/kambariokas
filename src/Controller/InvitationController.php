<?php

namespace App\Controller;

use App\Entity\Invite;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    /**
     * @Route("/invitation/{uuid}", name="invitation", methods={"GET"})
     */
    public function index($uuid, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $invite = new Invite();
        $invite->setSender($this->getUser());

        $userRepo = $em->getRepository(User::class);
        $receiver = $userRepo->findOneBy(['id'=>$uuid]);
        $invite->setReceiver($receiver);
        $invite->setStatus('pending');
        $em->persist($invite);
        $em->flush();

        return $this->render('invitation/index.html.twig', [
            'controller_name' => 'InvitationController',
        ]);
    }
}
