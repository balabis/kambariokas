<?php


namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Mgilet\NotificationBundle\Manager\NotificationManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NotificationService
{
    private $notificationManager;
    private $router;
    private $em;

    public function __construct(
        NotificationManager $notificationManager,
        UrlGeneratorInterface $router,
        EntityManagerInterface $em
    ) {
        $this->notificationManager = $notificationManager;
        $this->router = $router;
        $this->em = $em;
    }

    public function notifyAboutNewMessage(
        $messageReceiver,
        $messageSender,
        $threadId
    ) {
        $allNotifications =
            $this->notificationManager->getNotifications($messageReceiver);
        $isAlreadyNotified = false;
        foreach ($allNotifications as $notification) {
            if ($notification->getNotification()
                    ->getLink() === $this->router->generate(
                        'app.message.thread',
                        ['threadId' => $threadId]
                    )) {
                $isAlreadyNotified = true;
                break;
            }
        }
        if (!$isAlreadyNotified) {
            $notif = $this->notificationManager->createNotification(
                'Žinutė',
                $messageSender->getFullName(),
                $this->router->generate(
                    'app.message.thread',
                    ['threadId' => $threadId]
                )
            );
            $this->notificationManager->addNotification(
                [$messageReceiver],
                $notif,
                true
            );
        }
    }

    public function notifyAboutInviteAction($name, $senderUser, $receiver)
    {
        $notif = $this->notificationManager->createNotification(
            $name,
            $senderUser->getFullName(),
            $this->router->generate(
                'profile.view',
                ['uuid' => $senderUser->getId()]
            )
        );
        $this->notificationManager->addNotification([$receiver], $notif, true);
    }

    public function removeInviteNotificationsByUser($user, $profileOwnerUuid)
    {
        $allNotifications = $this->notificationManager->getNotifications($user);
        foreach ($allNotifications as $notifiableNotification) {
            if ($notifiableNotification->getNotification()
                    ->getLink() === $this->router->generate(
                        'profile.view',
                        ['uuid' => $profileOwnerUuid]
                    )) {
                $currentNotification = $notifiableNotification->getNotification();
                $this->em->remove($notifiableNotification);
                $this->em->remove($currentNotification);
                $this->em->flush();
            }
        }
    }

    public function deleteNotificationOnChatDelete($user, $threadId)
    {
        $allNotifications = $this->notificationManager->getNotifications($user);
        foreach ($allNotifications as $notifiableNotification) {
            if ($notifiableNotification->getNotification()
                    ->getLink() === $this->router->generate(
                        'app.message.thread',
                        ['threadId' => $threadId]
                    )) {
                $this->em->remove($notifiableNotification);
                $this->em->remove($notifiableNotification->getNotification());
                $this->em->flush();
            }
        }
    }
}
