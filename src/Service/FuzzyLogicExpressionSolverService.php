<?php

namespace App\Service;

use App\Domain\Dto\ArithmeticExpressionDto;
use App\Domain\Dto\TestAttemptDto;
use App\Event\AnswerValidationSuccessEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

readonly class FuzzyLogicExpressionSolverService
{
    public function __construct(
        private ArithmeticExpressionParser $arithmeticExpressionParser,
        private QuizService                $quizService,
        private AnswerCombinatorService    $answerCombinatorService,
        private EventDispatcherInterface   $eventDispatcher,
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

        $compiledResult = $this->answerCombinatorService->combine($rightAnswersKeys);
        $this->eventDispatcher->dispatch(new AnswerValidationSuccessEvent(new TestAttemptDto(
            $expression->getExpression(),
            array_map(fn($answer) => $answer->getExpression(), $answers),
            $compiledResult
        )));

        return $compiledResult;
    }
}