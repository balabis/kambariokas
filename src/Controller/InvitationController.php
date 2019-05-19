<?php

namespace App\Controller;

use App\Entity\Invite;
use App\Entity\User;
use App\Services\EmailService;
use App\Services\MatchesPaginationService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/invitation")
 */
class InvitationController extends AbstractController
{
    /**
     * @Route("/{group}", name="invitation_get", methods={"GET"}, defaults={"group":"received"})
     */
    public function show(
        $group,
        EntityManagerInterface $em,
        MatchesPaginationService $ps,
        Request $request
    ) {
        $invitesRepo = $em->getRepository(Invite::class);
        if ($group === 'sent') {
            $invites = $invitesRepo->findSentInvites($this->getUser()->getId());
        } elseif ($group === 'received') {
            $invites = $invitesRepo->findReceivedInvites($this->getUser()->getId());
        }

        $invitesPagination = $ps->getPagerfanta($invites);
        $invitesPagination->setMaxPerPage(8);
        $invitesPagination->setCurrentPage($request->query->get('page', 1));

        return $this->render('invitation/index.html.twig', [
            'invites' => $invitesPagination,
            'group' => $group
        ]);
    }

    /**
     * @Route("/sent", name="invitation_sent", methods={"POST"})
     */
    public function invite(
        EntityManagerInterface $em,
        Request $request,
        EmailService $emailService
    ) {
        $uuid = $request->request->get('uuid');
        $invite = new Invite();
        $invite->setSender($this->getUser());

        $userRepo = $em->getRepository(User::class);
        $receiver = $userRepo->findOneBy(['id' => $uuid]);

        $invite->setReceiver($receiver);
        $invite->setStatus('pending');
        $em->persist($invite);
        $em->flush();

        $emailService->sentInvitationEmail(
            $receiver->getEmail(),
            $this->getUser()
        );

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cancel", name="invitation_cancel", methods={"POST"})
     */
    public function cancelInvitation(Request $request, EntityManagerInterface $em, EmailService $emailService)
    {
        $uuid = $request->request->get('uuid');

        $inviteRepo = $em->getRepository(Invite::class);
        $invite = $inviteRepo->findOneBy(['sender'=>$this->getUser(), 'receiver'=>$uuid]);
        $em->remove($invite);
        $em->flush();

        $emailService->sentInviteCancelEmail($invite->getReceiver()->getEmail(), $this->getUser());

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/decline", name="invitation_decline", methods={"POST"})
     */
    public function declineInvitation(Request $request, EntityManagerInterface $em, EmailService $emailService)
    {
        $uuid = $request->request->get('uuid');

        $inviteRepo = $em->getRepository(Invite::class);
        $invite = $inviteRepo->findOneBy(['receiver'=>$this->getUser(), 'sender'=>$uuid]);
        $invite->setStatus('declined');
        $em->flush();

        $emailService->sentDeclineInvitationEmail($invite->getSender()->getEmail(), $this->getUser());

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/accept", name="invitation_accept", methods={"POST"})
     */
    public function acceptInvitation(Request $request, EntityManagerInterface $em, EmailService $emailService)
    {
        $uuid = $request->request->get('uuid');

        $inviteRepo = $em->getRepository(Invite::class);
        $invite = $inviteRepo->findOneBy(['receiver'=>$this->getUser(), 'sender'=>$uuid]);
        $invite->setStatus('accepted');
        $em->flush();

        $emailService->sentAcceptInvitationEmail($invite->getSender()->getEmail(), $this->getUser());

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/decision/cancel", name="invitation_decision_cancel", methods={"POST"})
     */
    public function cancelInvitationDecision(Request $request, EntityManagerInterface $em)
    {
        $uuid = $request->request->get('uuid');

        $inviteRepo = $em->getRepository(Invite::class);
        $invite = $inviteRepo->findOneBy(['receiver'=>$this->getUser(), 'sender'=>$uuid]);
        $invite->setStatus('pending');
        $em->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}
