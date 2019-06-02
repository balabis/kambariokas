<?php


namespace App\Controller;

use App\Services\NotificationService;
use App\Services\UserService;
use Doctrine\Common\Collections\Criteria;
use FOS\MessageBundle\Composer\Composer;
use FOS\MessageBundle\Deleter\Deleter;
use FOS\MessageBundle\EntityManager\ThreadManager;
use FOS\MessageBundle\FormFactory\ReplyMessageFormFactory;
use FOS\MessageBundle\FormHandler\ReplyMessageFormHandler;
use FOS\MessageBundle\Provider\ProviderInterface;
use FOS\MessageBundle\Sender\Sender;
use Mgilet\NotificationBundle\Manager\NotificationManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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

        if (empty($threads)) {
            return $this->render('@FOSMessage/Message/noThreads.html.twig');
        }

        return new RedirectResponse($this->container->get('router')->generate('app.message.thread', [
            'threadId' => $threads[0]->getId(),
        ]));
    }

    /**
     * @Route("/thread/{threadId}", name="app.message.thread")
     */
    public function threadAction($threadId, NotificationService $notificationService)
    {
        $inboxThreads = $this->provider->getInboxThreads();
        $sentThreads = $this->provider->getSentThreads();
        $threads = array_unique(array_merge($inboxThreads, $sentThreads), SORT_REGULAR);
        $thread = $this->provider->getThread($threadId);

        $form = $this->replyMessageFormFactoryformFactory->create($thread);
        if ($message = $this->replyMessageFormHandlerformHandler->process($form)) {
            $receiver = $thread->getOtherParticipants($this->getUser());
            $notificationService->notifyAboutNewMessage($receiver[0], $this->getUser(), $threadId);

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
    public function newThreadAction(UserService $userService, $participantId, NotificationService $notificationService)
    {
        $inboxThreads = $this->provider->getInboxThreads();
        $sentThreads = $this->provider->getSentThreads();
        $deletedThreads = $this->provider->getDeletedThreads();
        $threads = array_unique(array_merge($inboxThreads, $sentThreads, $deletedThreads), SORT_REGULAR);
        $recipient = $userService->getUserByUUID($participantId);

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

        // redirect to the newly created thread
        foreach ($sentThreads as $sentThread) {
            $threadParticipants = $sentThread->getParticipants();
            foreach ($threadParticipants as $threadParticipant) {
                if ($threadParticipant->getId() == $participantId) {
                    $notificationService->notifyAboutNewMessage($recipient, $this->getUser(), $sentThread->getId());

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
    public function deletedAction($threadId, NotificationService $notificationService)
    {
        $thread = $this->provider->getThread($threadId);
        $this->deleter->markAsDeleted($thread);
        $this->threadManager->saveThread($thread);
        $notificationService->deleteNotificationOnChatDelete($this->getUser(), $threadId);

        return new RedirectResponse($this->container->get('router')->generate('app.message.inbox'));
    }


    private function getSortedMessages($collection)
    {
        $criteria = Criteria::create()
            ->orderBy(array('created_at' => Criteria::ASC));

        return $collection->matching($criteria);
    }
}
