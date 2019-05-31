<?php


namespace App\Controller;


use Mgilet\NotificationBundle\Manager\NotificationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationsController extends AbstractController
{
    /**
     * @Route("/notification/delete", name="delete_notification", methods={"POST"})
     */
    public function deleteNotification(Request $request, NotificationManager $manager)
    {
        $notifId = $request->request->get('notificationId');
        $notification = $manager->getNotification($notifId);
        $manager->removeNotification(array($this->getUser()), $notification, true);
        $manager->deleteNotification($notification, true);

        return $this->redirect($notification->getLink());
    }

    /**
     * @Route("/api/notification", name="api_notifications", methods={"POST"})
     */
    public function getNotifications(NotificationManager $notManager)
    {
        $notifications = $notManager->getNotifications($this->getUser(), 'ASC', 10);

        return $this->json($notifications);
    }
}