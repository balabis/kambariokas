<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Mgilet\NotificationBundle\Entity\NotifiableEntity;
use Mgilet\NotificationBundle\Entity\NotifiableNotification;
use Mgilet\NotificationBundle\Entity\Notification;
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
//        $notifiableNotificationRepo = $em->getRepository(NotifiableNotification::class);
//        $notifiableNotification = $notifiableNotificationRepo->findBy(['id'=>$notifId]);

//        $notifiableEntityRepo = $em->getRepository(NotifiableEntity::class);
//        $notifiableEntityRepo->removeNotifiableNotification($notifiableNotification);
        $manager->removeNotification(array($this->getUser()), $notification, true);
        $manager->deleteNotification($notification, true);
//        $notification = $notificationRepo->findOneBy(['id'=>$notifId]);
//        $manager->r
//
        return $this->redirect($notification->getLink());
    }

    /**
     * @Route("/api/notification", name="api_notifications", methods={"POST"})
     */
    public function getNotifications(NotificationManager $notManager)
    {
        $notifications = $notManager->getNotifications($this->getUser());

        return $this->json($notifications);
    }
}