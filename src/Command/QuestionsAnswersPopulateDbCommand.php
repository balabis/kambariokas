<?php

namespace App\Command;

use App\Entity\Question;
use App\Entity\Questionnaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $this->loadQuestionnaire($this->em, 'sociability', 0);
        $this->loadQuestionnaire($this->em, 'socialOpenness', 1);
        $this->loadQuestionnaire($this->em, 'socialFlexibility', 2);
        $this->loadQuestionnaire($this->em, 'cleanliness', 3);

        $this->loadQuestion(
            $this->em,
            'I tend to go out to meet friends, socialize or network most evenings',
            'sociability',
            0
        );
        $this->loadQuestion(
            $this->em,
            'I like to have people over for drinks on a regular basis',
            'sociability',
            1
        );
        $this->loadQuestion(
            $this->em,
            'I like having friends staying over for a few days',
            'sociability',
            2
        );
        $this->loadQuestion(
            $this->em,
            'I would like my shared house to be known as a place to party',
            'sociability',
            3
        );
        $this->loadQuestion(
            $this->em,
            'I sometimes go out and come home in the early hours',
            'sociability',
            4
        );
        $this->loadQuestion(
            $this->em,
            'Occasionally I bring people I have just met to my house',
            'sociability',
            5
        );

        $this->loadQuestion(
            $this->em,
            'There should be a rota for putting the bins out',
            'cleanliness',
            6
        );
        $this->loadQuestion(
            $this->em,
            'I like to sort my spices and herbs clearly',
            'cleanliness',
            7
        );
        $this->loadQuestion(
            $this->em,
            'I like the fridge clean and organized',
            'cleanliness',
            8
        );
        $this->loadQuestion(
            $this->em,
            'There should be a rota for allocating household chores',
            'cleanliness',
            9
        );
        $this->loadQuestion(
            $this->em,
            'I am usually the person nagging others to tidy up',
            'cleanliness',
            10
        );
        $this->loadQuestion(
            $this->em,
            'I see flatmates as people I live with rather than friends',
            'socialOpenness',
            11
        );
        $this->loadQuestion(
            $this->em,
            'If I could choose, I would prefer to live alone',
            'socialOpenness',
            12
        );
        $this->loadQuestion(
            $this->em,
            'I prefer to eat in my room rather than in the communal areas',
            'socialOpenness',
            13
        );
        $this->loadQuestion(
            $this->em,
            'I spend most of my time in my room',
            'socialOpenness',
            14
        );
        $this->loadQuestion(
            $this->em,
            'I don\'t mind if my flatmates invite friends to our house, as long as they give me notice',
            'socialFlexibility',
            15
        );
        $this->loadQuestion(
            $this->em,
            'I am relaxed about the sexual choice of my flatmates',
            'socialFlexibility',
            16
        );
        $this->loadQuestion(
            $this->em,
            'It is sometimes OK to break the rules',
            'socialFlexibility',
            17
        );
        $this->loadQuestion(
            $this->em,
            'I am relaxed about the religious choices of my flatmates',
            'socialFlexibility',
            18
        );
        $this->loadQuestion(
            $this->em,
            'I am happy to help a flatmate with a personal task, e.g. ironing a shirt or giving them a lift somewhere',
            'socialFlexibility',
            19
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
        $questionnaire = $repo->findOneBy(['title'=>$questionnaireTitle]);
        $question = new Question();
        $question->setQuestionText($text);
        $question->setQuestionnaireId($questionnaire->getId());
        $question->setOrderNumber($orderNumber);
        $question->setQuestionnaire($questionnaire);
        $em->persist($question);
        $em->flush();
    }
}
