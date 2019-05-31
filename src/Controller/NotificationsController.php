<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Mgilet\NotificationBundle\Manager\NotificationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationsController extends AbstractController
{
    /**
     * @Route("/notification/delete", name="delete_notification", methods={"POST"})
     */
    public function deleteNotification(Request $request, NotificationManager $manager, EntityManagerInterface $em)
    {
        $notifId = $request->request->get('notificationId');
        $notification = $manager->getNotification($notifId);

        $em->remove($notification->getNotifiableNotifications()[0]);
        $em->remove($notification);
        $em->flush();

        return $this->redirect($notification->getLink());
    }

    /**
     * @Route("/api/notification", name="api_notifications", methods={"POST"})
     */
    public function getNotifications(NotificationManager $notManager)
    {
        $notifications = $notManager->getNotifications($this->getUser(), 'ASC', 15);

        return $this->json($notifications);
    }
}