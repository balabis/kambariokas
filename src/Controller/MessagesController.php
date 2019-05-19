<?php


namespace App\Controller;

use App\Services\UserService;
use Doctrine\Common\Collections\Criteria;
use FOS\MessageBundle\Composer\Composer;
use FOS\MessageBundle\Deleter\Deleter;
use FOS\MessageBundle\EntityManager\ThreadManager;
use FOS\MessageBundle\FormFactory\ReplyMessageFormFactory;
use FOS\MessageBundle\FormHandler\ReplyMessageFormHandler;
use FOS\MessageBundle\Provider\ProviderInterface;
use FOS\MessageBundle\Sender\Sender;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/dashboard/messages")
 */
class MessagesController extends AbstractController
{

    public function __construct(
        ProviderInterface $provider,
        ReplyMessageFormFactory $replyMessageFormFactoryformFactory,
        ReplyMessageFormHandler $replyMessageFormHandlerformHandler,
        Composer $composer,
        Sender $sender,
        Deleter $deleter,
        ThreadManager $threadManager
    ) {
        $this->provider = $provider;
        $this->replyMessageFormFactoryformFactory = $replyMessageFormFactoryformFactory;
        $this->replyMessageFormHandlerformHandler = $replyMessageFormHandlerformHandler;
        $this->composer = $composer;
        $this->sender = $sender;
        $this->deleter = $deleter;
        $this->threadManager = $threadManager;
    }

    protected $provider;
    protected $replyMessageFormFactoryformFactory;
    protected $replyMessageFormHandlerformHandler;
    protected $composer;
    protected $sender;
    protected $deleter;
    protected $threadManager;

    /**
     * @Route("/", name="app.message.inbox")
     */
    public function inboxAction()
    {
        $inboxThreads = $this->provider->getInboxThreads();
        $sentThreads = $this->provider->getSentThreads();
        $threads = array_unique(array_merge($inboxThreads, $sentThreads), SORT_REGULAR);

        // Sort threads from newest based on last messages.
        usort($threads, function ($a, $b) {
            return $b->getLastMessage()->getCreatedAt() <=> $a->getLastMessage()->getCreatedAt();
        });

        return $this->render('@FOSMessage/Message/inbox.html.twig', array(
            'threads' => $threads,
        ));
    }

    /**
     * @Route("/thread/{threadId}", name="app.message.thread")
     */
    public function threadAction($threadId)
    {
        $inboxThreads = $this->provider->getInboxThreads();
        $sentThreads = $this->provider->getSentThreads();
        $threads = array_unique(array_merge($inboxThreads, $sentThreads), SORT_REGULAR);

        $thread = $this->provider->getThread($threadId);

        $form = $this->replyMessageFormFactoryformFactory->create($thread);
        if ($message = $this->replyMessageFormHandlerformHandler->process($form)) {
            return new RedirectResponse($this->container->get('router')->generate('app.message.thread', array(
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
     * @Route("/new/{participantId}", name="app.message.new_thread")
     */
    public function newThreadAction(UserService $userService, $participantId)
    {
        $recipient = $userService->getUserByUUID($participantId);
        $threads = $this->provider->getInboxThreads();

        // If there is a thread with this user already, return it.
        foreach ($threads as $thread) {
            $threadParticipants = $thread->getParticipants();
            foreach ($threadParticipants as $threadParticipant) {
                if ($threadParticipant->getId() == $participantId) {
                    return new RedirectResponse(
                        $this->container->get('router')->generate(
                            'app.message.thread',
                            array('threadId' => $thread->getId())
                        )
                    );
                }
            }
        }

        // If there is no thread with this user, create a new one.
        $message = $this->composer->newThread()
            ->setSender($this->getUser())
            ->addRecipient($recipient)
            ->setSubject('Hi!')
            ->setBody('Labas!')
            ->getMessage();

        $this->sender->send($message);
        $sentThreads = $this->provider->getSentThreads();
        foreach ($sentThreads as $sentThread) {
            $threadParticipants = $sentThread->getParticipants();
            foreach ($threadParticipants as $threadParticipant) {
                if ($threadParticipant->getId() == $participantId) {
                    return new RedirectResponse(
                        $this->container->get('router')->generate(
                            'app.message.thread',
                            array('threadId' => $sentThread->getId())
                        )
                    );
                }
            }
        }
    }

    /**
     * @Route("/{threadId}/delete", name="app.message.delete_thread")
     */
    public function deletedAction($threadId)
    {
        $thread = $this->provider->getThread($threadId);
        $this->deleter->markAsDeleted($thread);
        $this->threadManager->saveThread($thread);

        return new RedirectResponse($this->container->get('router')->generate('app.message.inbox'));
    }


    private function getSortedMessages($collection)
    {
        $criteria = Criteria::create()
            ->orderBy(array('created_at' => Criteria::ASC));

        return $collection->matching($criteria);
    }
}
