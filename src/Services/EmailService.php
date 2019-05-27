<?php


namespace App\Services;

use Twig\Environment;

class EmailService
{
    private $mailer;
    private $twigEnvironment;

    public function __construct(
        \Swift_Mailer $mailer,
        Environment $twigEnvironment
    ) {
        $this->mailer = $mailer;
        $this->twigEnvironment = $twigEnvironment;
    }

    private function sentEmail($email, $firstParagraph, $secondParagraph, $subject)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom('geriausiaskambariokas@gmail.com')
            ->setTo($email)
            ->setBody(
                $this->twigEnvironment->render(
                    'emails/invitation.html.twig',
                    [
                        'firstParagraph' => $firstParagraph,
                        'secondParagraph'=>$secondParagraph
                    ]
                ),
                'text/html'
            );

        $this->mailer->send($message);
    }

    public function sentInvitationEmail($email, $senderUser)
    {
        $firstParagraph =
            'Informuojame, kad rumis.&#8203;io vartotojas ' .
            $senderUser->getFullName() . ' išsiuntė Jums kvietimą tapti kambariokais.';

        $secondParagraph =
            'Norėdami peržiūrėti ir patvirtinti arba atmesti 
            kvietimą spauskite mygtuką apačioje. Linkime geros dienos!';

        $subject = 'Kvietimas tapti kambariokais';

        $this->sentEmail($email, $firstParagraph, $secondParagraph, $subject);
    }

    public function sentInviteCancelEmail($email, $senderUser)
    {
        $firstParagraph =
            'Informuojame, kad rumis.&#8203;io vartotojas ' .
            $senderUser->getFullName() . ' atšaukė Jums išsiųstą kvietimą tapti kambariokais.';

        $secondParagraph =
            'Norėdami peržiūrėti Jūsų išsiųstus ar gautus pakvietimus spauskite mygtuką apačioje. 
            Linkime geros dienos!';

        $subject = 'Atšauktas kvietimas tapti kambariokais';

        $this->sentEmail($email, $firstParagraph, $secondParagraph, $subject);
    }

    public function sentAcceptInvitationEmail($email, $senderUser)
    {
        $firstParagraph =
            'Informuojame, kad rumis.&#8203;io vartotojas ' .
            $senderUser->getFullName() . ' priėmė Jūsų išsiųstą kvietimą tapti kambariokais.';

        $secondParagraph =
            'Vartotojo el. paštas: ' . $senderUser->getEmail() .
            '. Linkime geros dienos!';

        $subject = 'Priimtas kvietimas tapti kambariokais';

        $this->sentEmail($email, $firstParagraph, $secondParagraph, $subject);
    }

    public function sentDeclineInvitationEmail($email, $senderUser)
    {
        $firstParagraph =
            'Informuojame, kad rumis.&#8203;io vartotojas ' .
            $senderUser->getFullName() . ' atmetė Jūsų išsiųstą kvietimą tapti kambariokais.';

        $secondParagraph =
            'Norėdami gauti daugiau informacijos spauskite mygtuką apačioje. 
            Linkime geros dienos!';

        $subject = 'Atmestas kvietimas tapti kambariokais';

        $this->sentEmail($email, $firstParagraph, $secondParagraph, $subject);
    }

    public function sentContactInfoEmail ($email, $user)
    {
        $firstParagraph =
            'Jūs patvirtinote ' .
            $user->getFullName() . ' kvietimą tapti kambariokais.';

        $secondParagraph =
            'Vartotojo el. paštas: ' . $user->getEmail() .
            '. Linkime geros dienos!';

        $subject = 'Priimtas kvietimas tapti kambariokais';

        $this->sentEmail($email, $firstParagraph, $secondParagraph, $subject);
    }
}
