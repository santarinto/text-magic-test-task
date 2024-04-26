<?php

namespace App\Service;

use App\Domain\Dto\ArithmeticExpression;

class QuizService
{
    /**
     * @param ArithmeticExpression $expression
     * @param ArithmeticExpression[] $answers
     * @return ArithmeticExpression[]
     */
    public function findRightAnswers(ArithmeticExpression $expression, array $answers): array {
        $rightAnswers = [];

        foreach ($answers as $answer) {
            if ($expression->getResult() === $answer->getResult()) {
                $rightAnswers[] = $answer;
            }
        }

        return $rightAnswers;
    }
}