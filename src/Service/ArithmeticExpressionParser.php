<?php

namespace App\Service;

use App\Domain\Dto\ArithmeticExpressionDto;
use App\Exception\WrongArithmeticExpression;

class ArithmeticExpressionParser
{
    public const WRONG_EXPRESSION_ERROR_MESSAGE = 'The expression is not correct, allow only "int" or "int + int" or "int + int =" format.';

    public function parse(string $expression): ArithmeticExpressionDto {
        $additionPattern = '/^(\d+)\s*\+\s*(\d+)\s*=?\s*$/';
        $numberPattern = '/^\d+$/';

        if (preg_match($additionPattern, $expression, $matches)) {
            $result = $this->calculateSum((int)$matches[1], (int)$matches[2]);

            return new ArithmeticExpressionDto($expression, $result);
        } elseif (preg_match($numberPattern, $expression)) {
            return new ArithmeticExpressionDto($expression, (int)$expression);
        }

        throw new WrongArithmeticExpression(self::WRONG_EXPRESSION_ERROR_MESSAGE);
    }

    private function calculateSum(int $num1, int $num2): int {
        return $num1 + $num2;
    }
}