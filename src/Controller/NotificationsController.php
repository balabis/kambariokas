<?php


namespace App\Controller;


use Mgilet\NotificationBundle\Manager\NotificationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NotificationsController extends AbstractController
{
    /**
     * @Route("/send-notification", name="send_notification")
     */
    public function sendNotification(Request $request, NotificationManager $manager)
    {



        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($this->getUser()), $notif, true);

        //return $this->redirectToRoute('matched');
    }
}