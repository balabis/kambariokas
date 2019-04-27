<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Questionnaire;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{
    /**
     * @Route("/questionnaire/{slug}", name="questionnaire")
     */
    public function show($slug, EntityManagerInterface $em)
    {
        $questionnaireRepository = $em->getRepository(Questionnaire::class);
        $questionnaire = $questionnaireRepository->findOneBy(['title'=>$slug]);
        if (!$questionnaire) {
            throw $this->createNotFoundException('No ' . $slug . ' questionnaire found!');
        }

        $questionRepository = $em->getRepository(Question::class);
        $questions = $questionRepository->findQuestionsByQuestionnaire($questionnaire->getId());





        return $this->render('questionnaire/index.html.twig', [
            'questions' => $questions,
            'questionnaireTitle' => $questionnaire->getTitle(),
        ]);
    }

}
