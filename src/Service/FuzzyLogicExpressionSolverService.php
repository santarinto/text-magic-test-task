<?php

namespace App\Service;

use App\Domain\Dto\ArithmeticExpressionDto;

class FuzzyLogicExpressionSolverService
{
    public function __construct(
        private readonly ArithmeticExpressionParser $arithmeticExpressionParser,
        private readonly QuizService                $quizService,
        private readonly AnswerCombinatorService    $answerCombinatorService,
    ) {}

    public function solve(string $expression, array $suitableAnswers): string {
        $expression = $this->arithmeticExpressionParser->parse($expression);
        /** @var ArithmeticExpressionDto[] $answers */
        $answers = array_map(fn($answer) => $this->arithmeticExpressionParser->parse($answer), $suitableAnswers);
        $rightAnswers = $this->quizService->findRightAnswers($expression, $answers);
        $rightAnswersKeys = [];

        $sizeSuitableAnswers = count($suitableAnswers);
        $sizeRightAnswers = count($rightAnswers);

        for ($i = 0; $i < $sizeSuitableAnswers; $i++) {
            for ($n = 0; $n < $sizeRightAnswers; $n++) {
                if ($answers[$i]->getResult() === $rightAnswers[$n]->getResult()) {
                    $rightAnswersKeys[] = $i + 1;
                    break;
                }
            }
        }

        return $this->answerCombinatorService->combine($rightAnswersKeys);
    }
}