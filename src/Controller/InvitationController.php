<?php

namespace App\Controller;

use App\Entity\Invite;
use App\Entity\User;
use App\Entity\UserMatch;
use App\Services\MatchesPaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InvitationController extends AbstractController
{
    /**
     * @Route("/invitation", name="invitation_get", methods={"GET"})
     */
    public function show(EntityManagerInterface $em, MatchesPaginationService $ps, Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $invitesRepo = $em->getRepository(Invite::class);
        $invites = $invitesRepo->findSentInvites($this->getUser()->getId());
        $invitesPagination = $ps->getPagerfanta($invites);
        $invitesPagination->setMaxPerPage(8);
        $invitesPagination->setCurrentPage($request->query->get('page', 1));
//        dd($invitesPagination);
        return $this->render('invitation/index.html.twig', [
            'invites'=>$invitesPagination
        ]);
    }


    /**
     * @Route("/invitation", name="invitation_post", methods={"POST"})
     */
    public function index(EntityManagerInterface $em, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $uuid = $request->request->get('uuid');
        $invite = new Invite();
        $invite->setSender($this->getUser());

        $userRepo = $em->getRepository(User::class);
        $receiver = $userRepo->findOneBy(['id'=>$uuid]);


        $invite->setReceiver($receiver);
        $invite->setStatus('pending');
        $em->persist($invite);
        $em->flush();



        return $this->redirect($request->headers->get('referer'));
    }
}
