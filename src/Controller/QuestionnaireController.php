<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\UserAnswer;
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
     * @Route("/questionnaire/{slug}", name="questionnaire_get",
     *     defaults={"slug"="flat"}, methods={"GET"})
     */
    public function show(
        $slug,
        EntityManagerInterface $em,
        AnswerService $answerService
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $questionnaireRepository = $em->getRepository(Questionnaire::class);
        $questionnaire =
            $questionnaireRepository->findOneBy(['title' => $slug]);

        if (!$questionnaire) {
            throw $this->createNotFoundException('No ' . $slug . ' questionnaire found!');
        }

        $questionRepository = $em->getRepository(Question::class);
//        $questions = $questionRepository->findBy(
//            [],
//            [
//                'orderNumber' => 'ASC',
//            ]);

        $questions = $questionRepository->findAllJoinedWithQuestionnaire();
//                dd($questions);

        return $this->render('questionnaire/index.html.twig', [
            'questions' => $questions,
            'answers' => $answerService->generateAnswers(),
            'questionnaireTitle' => $questionnaire->getTitle(),
            'contentName' => $questionnaire->getTitle(),
        ]);
    }

    /**
     * @Route("/questionnaire/{slug}", name="questionnaire_post",
     *     methods={"POST"})
     */
    public function formSubmission(
        Request $request,
        EntityManagerInterface $em,
        UserInterface $user,
        QuestionnaireScoreService $questionnaireScore
    ) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if ($request->attributes->get('_route') === 'questionnaire_post' && $request->isMethod('POST')) {

            $questionnaireScore = $questionnaireScore->calculateQuestionnaireScore($request);
            dd($request);
            //
            //
            //        if ($request->attributes->get('slug') === 'flat') {
            //            return $this->redirectToRoute('questionnaire_get', ['slug'=>'personal']);
        }

        return $this->redirectToRoute('matched');
    }
}
