<?php


namespace App\Services;


class AnswerService
{
    private $maxAnswerValue;

    public function __construct()
    {
        $this->maxAnswerValue = 5;
    }

    public function generateAnswers(): array
    {
        return [
            5 => ['answerText' => 'Visiškai sutinku', 'answerEmoji' => '&#128513;'],
            4 => ['answerText' => 'Sutinku', 'answerEmoji' => '&#128522;'],
            3 => ['answerText' => 'Šiek tiek sutinku', 'answerEmoji' => '&#128524;'],
            2 => ['answerText' => 'Šiek tiek nesutinku', 'answerEmoji' => '&#128528;'],
            1 => ['answerText' => 'Nesutinku', 'answerEmoji' => '&#128532;'],
            0 => ['answerText' => 'Visiškai nesutinku', 'answerEmoji' => '&#128534;'],
        ];
    }

    public function getMaxAnswerValue(): int
    {
        return $this->maxAnswerValue;
    }
}
