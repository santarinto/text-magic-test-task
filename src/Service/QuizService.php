<?php

namespace App\Service;

use App\Domain\Dto\ArithmeticExpressionDto;

class QuizService
{
    /**
     * @param ArithmeticExpressionDto $expression
     * @param ArithmeticExpressionDto[] $answers
     * @return ArithmeticExpressionDto[]
     */
    public function findRightAnswers(ArithmeticExpressionDto $expression, array $answers): array {
        $rightAnswers = [];

        foreach ($answers as $answer) {
            if ($expression->getResult() === $answer->getResult()) {
                $rightAnswers[] = $answer;
            }
        }

        return $rightAnswers;
    }
}