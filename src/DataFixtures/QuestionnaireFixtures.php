<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\QuestionAnswers;
use App\Entity\Questionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class QuestionnaireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $this->loadQuestionnaires($manager);
        $this->loadQuestions($manager, 10);
        $this->loadAnswers($manager, 4);


    }

    public function loadQuestionnaires($manager) {
        $questionnaire = new Questionnaire();
        $questionnaire->setTitle('flat');
        $manager->persist($questionnaire);


        $questionnaire = new Questionnaire();
        $questionnaire->setTitle('personal');
        $manager->persist($questionnaire);

        $manager->flush();
    }

    public function loadQuestions($manager, $number) {
        $repo = $manager->getRepository(Questionnaire::class);

        $questionnaires = $repo->findAll();
        foreach($questionnaires as $questionnaire) {
            for ($i = 0; $i < $number; $i++) {
                $question = new Question();
                $question->setQuestionText('Megstamiausia Jusu Spalva' . $questionnaire->getTitle() . $i);
                $question->setQuestionnaireId($questionnaire->getId());

                $manager->persist($question);
                $manager->flush();
            }
        }

    }

    public function loadAnswers($manager, $number) {
        $repo = $manager->getRepository(Question::class);

        $questions = $repo->findAll();
        foreach($questions as $question) {
            for ($i = 0; $i < $number; $i++) {
                $answer = new QuestionAnswers();
                $answer->setAnswerText('Melyna ' . $question->getQuestionText() . $i);
                $answer->setQuestionId($question->getId());
                $answer->setQuestion($question);
                $manager->persist($answer);
                $manager->flush();
            }
        }
    }
}
