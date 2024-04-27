<?php

namespace App\Domain\Dto;

class TestAttemptDto
{
    private string $expression;

    /**
     * @var string[]|null
     */
    private array $results;
    private string $compiledAnswer;

    /**
     * @param string $expression
     * @param string[] $results
     * @param string $compiledAnswer
     */
    public function __construct(string $expression, array $results, string $compiledAnswer) {
        $this->expression = $expression;
        $this->results = $results;
        $this->compiledAnswer = $compiledAnswer;
    }

    public function getExpression(): ?string {
        return $this->expression;
    }

    public function getResults(): ?array {
        return $this->results;
    }

    public function getCompiledAnswer(): ?string {
        return $this->compiledAnswer;
    }
}