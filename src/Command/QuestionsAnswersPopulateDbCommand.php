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
        $this->loadQuestionnaire($this->em, 'flat');
        $this->loadQuestionnaire($this->em, 'personal');

        $this->loadQuestion(
            $this->em,
            'Kelių kambarių buto pageidaujate?',
            'flat',
            ['Vieno', 'Dviejų', 'Trijų', 'Keturių', 'Nesvarbu']
        );
        $this->loadQuestion(
            $this->em,
            'Kokia pageidaujama buto nuomos kaina asmeniui per mėnesį?',
            'flat',
            ['<50€', '50€-100€', '100€-150€', '>150€']
        );
        $this->loadQuestion(
            $this->em,
            'Su keliais namiokais norėtumėte gyvent?',
            'flat',
            ['Vienu', 'Dviem', 'Trim', 'Daugiau nei trim', 'Nesvarbu']
        );
        $this->loadQuestion(
            $this->em,
            'Ar reikalinga parkavimo vieta?',
            'flat',
            ['Taip', 'Ne']
        );
        $this->loadQuestion(
            $this->em,
            'Ar reikalingas kiemas?',
            'flat',
            ['Taip', 'Ne']
        );
        $this->loadQuestion(
            $this->em,
            'Kokiam laikotarpiui ruošiesi nuomotis butą?',
            'flat',
            [
                'Mažiau nei trim mėnesiam',
                '3-6mėn',
                '6-12mėn',
                'Daugiau nei metus',
            ]
        );

        $this->loadQuestion(
            $this->em,
            'Ar sutinkate kad bute būtų augintiniai?',
            'personal',
            ['Taip', 'Ne']
        );
        $this->loadQuestion(
            $this->em,
            'Vakarėlis namuose gali būti organizuojamas?',
            'personal',
            [
                'Vieną kartą per savaitę',
                'Tris kartus per savaitę',
                'Priklausomai nuo mokymosi/darbo grafiko',
                'Niekada',
            ]
        );
        $this->loadQuestion(
            $this->em,
            'Namuose yra tvarkomasi?',
            'personal',
            [
                'Vieną kartą per savaitę',
                'Kas dvi savaites',
                'Dažniau',
                'Kam tas tvarkymasis?',
            ]
        );
        $this->loadQuestion(
            $this->em,
            'Ieškai namioko, kuris būtų?',
            'personal',
            [
                'Intravertas',
                'Ekstravertas',
                'Neapsisprendęs',
                'Svarbu normalus',
            ]
        );
        $this->loadQuestion(
            $this->em,
            'Gyvenčiau tik su?',
            'personal',
            ['Merginomis', 'Vaikinais', 'Nesvarbu']
        );
        $this->loadQuestion(
            $this->em,
            'Ieškai namioko?',
            'personal',
            ['18-25metų', '25-35metų', '35-50metų', 'Nesvarbu']
        );
        $this->loadQuestion(
            $this->em,
            'Ar neprieštarauji namuose garsiai leidžiamai muzikai?',
            'personal',
            ['Ne', 'Taip', 'Pats/pati leisiu', 'Su protu']
        );
        $this->loadQuestion(
            $this->em,
            'Koks jūsų požiūris į dažną kambariokų partnerio buvimą bute?',
            'personal',
            ['Neigiamas', 'Toleruoju', 'Toleruoju jei dalinamės išlaidas']
        );
    }

    public function loadQuestionnaire($em, $title)
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setTitle($title);
        $em->persist($questionnaire);
        $em->flush();
    }

    public function loadQuestion($em, $text, $questionnaireTitle, $answersArray)
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
        $em->persist($question);
        $em->flush();

        foreach ($answersArray as $answerText) {
            $answer = new QuestionAnswers();
            $answer->setAnswerText($answerText);
            $answer->setQuestionId($question->getId());
            $answer->setQuestion($question);
            $em->persist($answer);
            $em->flush();
        }
    }
}
