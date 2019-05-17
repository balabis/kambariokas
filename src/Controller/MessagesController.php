<?php


namespace App\Controller;

use App\Services\UserService;
use Doctrine\Common\Collections\Criteria;
use FOS\MessageBundle\FormFactory\ReplyMessageFormFactory;
use FOS\MessageBundle\FormHandler\NewThreadMessageFormHandler;
use FOS\MessageBundle\Provider\ProviderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/dashboard/messages")
 */
class MessagesController extends AbstractController
{

    public function __construct(
        ProviderInterface $provider,
        ReplyMessageFormFactory $formFactory,
        NewThreadMessageFormHandler $formHandler
    ) {
        $this->provider = $provider;
        $this->formFactory = $formFactory;
        $this->formHandler = $formHandler;
    }

    protected $provider;
    protected $formFactory;
    protected $formHandler;

    /**
     * @Route("/", name="app.message.inbox")
     */
    public function inboxAction()
    {
        $threads = $this->provider->getInboxThreads();

        return $this->render('@FOSMessage/Message/inbox.html.twig', array(
            'threads' => $threads,
        ));
    }

    /**
     * @Route("/sent", name="app.message.sent")
     */
    public function sentAction()
    {
        $threads = $this->provider->getSentThreads();

        return $this->render('@FOSMessage/Message/sent.html.twig', array(
            'threads' => $threads,
        ));
    }

    /**
     * @Route("/{threadId}", name="app.message.thread")
     */
    public function threadAction(UserService $userService, $threadId)
    {
        $threads = $this->provider->getInboxThreads();
        $thread = $this->provider->getThread($threadId);

        $form = $this->formFactory->create($thread);
        if ($message = $this->formHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('fos_message_thread_view', array(
                'threadId' => $message->getThread()->getId(),
            )));
        }

        $sortedMessages = $this->getSortedMessages($thread->getMessages());

        return $this->render('@FOSMessage/Message/thread.html.twig', array(
            'form' => $form->createView(),
            'thread' => $thread,
            'threads' => $threads,
            'messages' => $sortedMessages
        ));
    }

    /**
     * @Route("/new", name="app.message.new_thread")
     */
    public function newThreadAction()
    {
        $threads = $this->provider->getInboxThreads();
        foreach ($threads as $thread) {
            $threadParticipants = $thread->getParticipants();
            foreach ($threadParticipants as $threadParticipant) {
                dd($threadParticipant);
            }
        }
        $form = $this->formFactory->create();
        if ($message = $this->formHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('fos_message_thread_view', array(
                'threadId' => $message->getThread()->getId(),
            )));
        }

        return $this->render('@FOSMessage/Message/newThread.html.twig', array(
            'form' => $form->createView(),
            'data' => $form->getData(),
            'threads' => $threads,
        ));
    }

    /**
     * @Route("/{threadId}/delete", name="app.message.delete_thread")
     */
    public function deletedAction()
    {
        $threads = $this->provider->getDeletedThreads();

        return $this->render('@FOSMessage/Message/deleted.html.twig', array(
            'threads' => $threads,
        ));
    }


    private function getSortedMessages($collection)
    {
        $criteria = Criteria::create()
            ->orderBy(array('created_at' => Criteria::ASC));

        return $collection->matching($criteria);
    }
}