<?php


namespace App\Services;

use App\Entity\QuestionnaireScore;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class QuestionnaireScoreService
{
    private $answerService;
    private $em;

    public function __construct(AnswerService $answerService, EntityManagerInterface $em)
    {
        $this->answerService = $answerService;
        $this->em = $em;
    }

    public function calculateQuestionnaireScore(Request $request, string $questionnaireTitle): ?float
    {

        $answers = $request->request->get($questionnaireTitle);

        $maxScore = count($answers) * $this->answerService->getMaxAnswerValue();
        $score = 0;

        foreach ($answers as $key => $value) {
            $score += (int)$value;
        }

        $scoreIndex = $score / $maxScore;

        return number_format($scoreIndex, 2, '.', '');
    }

    public function deleteQuestionnaireScore($user)
    {
        $repo = $this->em->getRepository(QuestionnaireScore::class);
        $scores = $repo->findBy(['userId' => $user->getId()]);

        foreach ($scores as $score) {
            $this->em->remove($score);
        }

        $this->em->flush();
    }
}
