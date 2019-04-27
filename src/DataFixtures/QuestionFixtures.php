<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $question = new Question();
        $question->setQuestionText('Megstamiausia Jusu Spalva');


        $manager->flush();
    }
}
