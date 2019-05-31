<?php


namespace App\Services;


use Mgilet\NotificationBundle\Manager\NotificationManager;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class NotificationService
{
    private $notificationManager;
    private $router;

    public function __construct(NotificationManager $notificationManager, UrlGeneratorInterface $router)
    {
        $this->notificationManager = $notificationManager;
        $this->router = $router;
    }

    public function notifyAboutNewMessage($messageReceiver, $messageSender, $threadId)
    {
        $allNotifications =
            $this->notificationManager->getNotifications($messageReceiver[0]);
        $isAlreadyNotified = false;
        foreach ($allNotifications as $notification) {
            if ($notification->getNotification()
                ->getLink() === $this->router->generate('app.message.thread',
                ['threadId' => $threadId]))
            {
                $isAlreadyNotified = true;
                break;
            }
        }

        if (!$isAlreadyNotified) {
            $notif = $this->notificationManager->createNotification('Žinutė',
                $messageSender->getFullName(),
                $this->router->generate('app.message.thread',
                    ['threadId' => $threadId]));

            $this->notificationManager->addNotification($messageReceiver,
                $notif, true);
        }
    }

    public function notifyAboutInviteAction()
    {

    }
}