<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\QuestionnaireScore;
use App\Services\AnswerService;
use App\Services\QuestionnaireScoreService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class QuestionnaireController extends AbstractController
{
    /**
     * @Route("/questionnaire", name="questionnaire_get", methods={"GET"})
     */
    public function show(
        EntityManagerInterface $em,
        AnswerService $answerService
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $questionRepository = $em->getRepository(Question::class);
        $questions = $questionRepository->findAllJoinedWithQuestionnaire();

        return $this->render('questionnaire/index.html.twig', [
            'questions' => $questions,
            'answers' => $answerService->generateAnswers(),
        ]);
    }

    /**
     * @Route("/questionnaire", name="questionnaire_post",
     *     methods={"POST"})
     */
    public function formSubmission(
        Request $request,
        EntityManagerInterface $em,
        UserInterface $user,
        QuestionnaireScoreService $questionnaireScoreService
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->attributes->get('_route') === 'questionnaire_post' && $request->isMethod('POST')) {
            $sociabilityScore =
                $questionnaireScoreService->calculateQuestionnaireScore(
                    $request,
                    'sociability'
                );
            $cleanlinessScore =
                $questionnaireScoreService->calculateQuestionnaireScore(
                    $request,
                    'cleanliness'
                );
            $socialOpennessScore =
                $questionnaireScoreService->calculateQuestionnaireScore(
                    $request,
                    'socialOpenness'
                );
            $socialFlexibilityScore =
                $questionnaireScoreService->calculateQuestionnaireScore(
                    $request,
                    'socialFlexibility'
                );

            $questionnaireScoreService->deleteQuestionnaireScore($user);

            $questionnaireScore = new QuestionnaireScore();
            $questionnaireScore->setSociability($sociabilityScore);
            $questionnaireScore->setCleanliness($cleanlinessScore);
            $questionnaireScore->setSocialOpenness($socialOpennessScore);
            $questionnaireScore->setSocialFlexibility($socialFlexibilityScore);
            $questionnaireScore->setUserId($user->getId());
            $questionnaireScore->setUser($user);

            $em->persist($questionnaireScore);
            $em->flush();
        }

        return $this->redirectToRoute('matched');
    }
}
