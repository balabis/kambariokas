<?php

namespace App\DataFixtures;

use App\Entity\Questionnaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class QuestionnaireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $questionnaire = new Questionnaire();
        $questionnaire->setTitle('flat');
        $manager->persist($questionnaire);

        $questionnaire = new Questionnaire();
        $questionnaire->setTitle('personal');
        $manager->persist($questionnaire);

        $manager->flush();
    }
}
