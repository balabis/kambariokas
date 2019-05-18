<?php


namespace App\Services;


use Twig\Environment;


class EmailService
{
    private $mailer;
    private $twigEnvironment;

    public function __construct(\Swift_Mailer $mailer, Environment $twigEnvironment )
    {
        $this->mailer = $mailer;
        $this->twigEnvironment = $twigEnvironment;
    }

    public function sentInvitationEmail($email, $senderUser) {
        $message = (new \Swift_Message('Kvietimas tapti kambariokais'))
            ->setFrom('geriausiaskambariokas@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->twigEnvironment->render(
                    'emails/invitation.html.twig',
                    [
                        'senderName' => $senderUser->getFullName(),
                        'uuid'=>$senderUser->getId()
                    ]
                ),
                'text/html'
            );


        $this->mailer->send($message);
    }
}