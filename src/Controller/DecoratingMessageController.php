<?php


namespace App\Controller;


use FOS\MessageBundle\Controller\MessageController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DecoratingMessageController extends MessageController
{

    public function threadAction($threadId)
    {
        $threads = $this->getProvider()->getInboxThreads();
        $thread = $this->getProvider()->getThread($threadId);
        $form = $this->container->get('fos_message.reply_form.factory')->create($thread);
        $formHandler = $this->container->get('fos_message.reply_form.handler');
        if ($message = $formHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('fos_message_thread_view', array(
                'threadId' => $message->getThread()->getId(),
            )));
        }

        return $this->render('@FOSMessage/Message/thread.html.twig', array(
            'form' => $form->createView(),
            'thread' => $thread,
            'threads' => $threads
        ));
    }
}