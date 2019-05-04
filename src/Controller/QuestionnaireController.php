<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\UserAnswer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class QuestionnaireController extends AbstractController
{
    /**
     * @Route("/questionnaire/{slug}", name="questionnaire_get", defaults={"slug"="flat"}, methods={"GET"})
     */
    public function show($slug, EntityManagerInterface $em)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $questionnaireRepository = $em->getRepository(Questionnaire::class);
        $questionnaire = $questionnaireRepository->findOneBy(['title'=>$slug]);

        if (!$questionnaire) {
            throw $this->createNotFoundException('No ' . $slug . ' questionnaire found!');
        }

        $questionRepository = $em->getRepository(Question::class);
        $questions = $questionRepository->findQuestionsByQuestionnaireWithAnswers($questionnaire->getId());

        return $this->render('questionnaire/index.html.twig', [
            'questions' => $questions,
            'questionnaireTitle' => $questionnaire->getTitle(),
            'contentName' => $questionnaire->getTitle()
        ]);
    }

    /**
     * @Route("/questionnaire/{slug}", name="questionnaire_post", methods={"POST"})
     */
    public function formSubmission(Request $request, EntityManagerInterface $em, UserInterface $user)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->attributes->get('_route') === 'questionnaire_post' && $request->isMethod('POST')) {
            $questionAnswerPairs = $request->request->all();
            foreach ($questionAnswerPairs as $questionId => $answerId) {
                $userAnswer = new UserAnswer();
                $userAnswer->setQuestionId($questionId);
                $userAnswer->setQuestionAnswerId($answerId);
                $userAnswer->setUserId($user->getId());
                $em->persist($userAnswer);
                $em->flush();
            }
        }

        if ($request->attributes->get('slug') === 'flat') {
            return $this->redirectToRoute('questionnaire_get', ['slug'=>'personal']);
        }

        return $this->redirectToRoute('matched');
    }
}
