<?php


namespace App\Services;

use Symfony\Component\HttpFoundation\Request;

class QuestionnaireScoreService
{
    private $answerService;

    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
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
}
