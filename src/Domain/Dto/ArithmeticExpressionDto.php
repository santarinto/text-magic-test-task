<?php

namespace App\Domain\Dto;

class ArithmeticExpressionDto
{
    private string $expression;
    private int $result;

    public function __construct(string $expression, int $result) {
        $this->expression = $expression;
        $this->result = $result;
    }

    public function getExpression(): string {
        return $this->expression;
    }

    public function getResult(): int {
        return $this->result;
    }
}