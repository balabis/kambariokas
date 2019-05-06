<?php

namespace App\Command;

use App\Entity\Question;
use App\Entity\QuestionAnswers;
use App\Entity\Questionnaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class QuestionsAnswersPopulateDbCommand extends Command
{
    private $em;

    public function __construct(string $name = null, EntityManagerInterface $em)
    {
        parent::__construct($name);
        $this->em = $em;
    }

    protected static $defaultName = 'app:questions-answers-populate-db';

    protected function configure()
    {
        $this
            ->setDescription('Populate database with questions and answers');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->loadQuestionnaire($this->em, 'flat', 0);
        $this->loadQuestionnaire($this->em, 'personal', 1);

        $this->loadQuestion(
            $this->em,
            'Kelių kambarių buto pageidaujate?',
            'flat',
            0
        );
        $this->loadQuestion(
            $this->em,
            'Kokia pageidaujama buto nuomos kaina asmeniui per mėnesį?',
            'flat',
            1
        );
        $this->loadQuestion(
            $this->em,
            'Su keliais namiokais norėtumėte gyvent?',
            'flat',
            2
        );
        $this->loadQuestion(
            $this->em,
            'Ar reikalinga parkavimo vieta?',
            'flat',
            3
        );
        $this->loadQuestion(
            $this->em,
            'Ar reikalingas kiemas?',
            'flat',
            4
        );
        $this->loadQuestion(
            $this->em,
            'Kokiam laikotarpiui ruošiesi nuomotis butą?',
            'flat',
            5
        );

        $this->loadQuestion(
            $this->em,
            'Ar sutinkate kad bute būtų augintiniai?',
            'personal',
            0
        );
        $this->loadQuestion(
            $this->em,
            'Vakarėlis namuose gali būti organizuojamas?',
            'personal',
            1
        );
        $this->loadQuestion(
            $this->em,
            'Namuose yra tvarkomasi?',
            'personal',
            2
        );
        $this->loadQuestion(
            $this->em,
            'Ieškai namioko, kuris būtų?',
            'personal',
            3
        );
        $this->loadQuestion(
            $this->em,
            'Gyvenčiau tik su?',
            'personal',
            4
        );
        $this->loadQuestion(
            $this->em,
            'Ieškai namioko?',
            'personal',
            5
        );
        $this->loadQuestion(
            $this->em,
            'Ar neprieštarauji namuose garsiai leidžiamai muzikai?',
            'personal',
            6
        );
        $this->loadQuestion(
            $this->em,
            'Koks jūsų požiūris į dažną kambariokų partnerio buvimą bute?',
            'personal',
            7
        );
    }

    public function loadQuestionnaire($em, $title, $orderNumber)
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setTitle($title);
        $questionnaire->setOrderNumber($orderNumber);
        $em->persist($questionnaire);
        $em->flush();
    }

    public function loadQuestion($em, $text, $questionnaireTitle, $orderNumber)
    {
        $repo = $em->getRepository(Questionnaire::class);

        $questionnaires = $repo->findAll();
        $questionnaireId = null;
        foreach ($questionnaires as $questionnaire) {
            if ($questionnaire->getTitle() === $questionnaireTitle) {
                $questionnaireId = $questionnaire->getId();
            }
        }

        $question = new Question();
        $question->setQuestionText($text);
        $question->setQuestionnaireId($questionnaireId);
        $question->setOrderNumber($orderNumber);
        $em->persist($question);
        $em->flush();
    }
}
