<?php

namespace App\Tests\Unit\Service;

use App\Service\AnswerCombinatorService;
use App\Service\ArithmeticExpressionParser;
use App\Service\FuzzyLogicExpressionSolverService;
use App\Service\QuizService;
use App\Tests\Support\UnitTester;
use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * This should be a functional test. However, I encountered a problem with the
 * packages and did not resolve it. Technical debt in the test task. :)
 */
class FuzzyLogicExpressionSolverServiceTest extends Unit
{
    protected UnitTester $tester;
    private readonly FuzzyLogicExpressionSolverService $fuzzyLogicExpressionSolverService;
    private MockObject $eventDispatcher;

    protected function _before(): void {
        $this->eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $this->fuzzyLogicExpressionSolverService = new FuzzyLogicExpressionSolverService(
            new ArithmeticExpressionParser(),
            new QuizService(),
            new AnswerCombinatorService(),
            $this->eventDispatcher
        );
    }

    /**
     * @dataProvider expressionsProvider
     */
    public function testSolveExpressions(string $expression, array $suitableAnswers, string $expected): void {
        $this->setName($expression);

        $result = $this->fuzzyLogicExpressionSolverService->solve($expression, $suitableAnswers);

        $this->assertEquals($expected, $result);
    }

    private function expressionsProvider(): array {
        return [
            [
                'expression' => '1 + 1 =',
                'suitableAnswers' => [
                    '3',
                    '2',
                    '0',
                ],
                'expected' => '2'
            ],
            [
                'expression' => '2 + 2 =',
                'suitableAnswers' => [
                    '4',
                    '3 + 1',
                    '10',
                ],
                'expected' => '1 ИЛИ 2 ИЛИ (1 И 2)'
            ],
            [
                'expression' => '3 + 3 =',
                'suitableAnswers' => [
                    '1 + 5',
                    '1',
                    '6',
                    '2 + 4',
                ],
                'expected' => '1 ИЛИ 3 ИЛИ 4 ИЛИ (1 И 3) ИЛИ (1 И 4) ИЛИ (3 И 4) ИЛИ (1 И 3 И 4)'
            ],
            [
                'expression' => '4 + 4 =',
                'suitableAnswers' => [
                    '8',
                    '4',
                    '0',
                    '0 + 8'
                ],
                'expected' => '1 ИЛИ 4 ИЛИ (1 И 4)'
            ],
            [
                'expression' => '5 + 5 =',
                'suitableAnswers' => [
                    '6',
                    '18',
                    '10',
                    '9',
                    '0',
                ],
                'expected' => '3'
            ],
            [
                'expression' => '6 + 6 =',
                'suitableAnswers' => [
                    '3',
                    '9',
                    '0',
                    '12',
                    '5 + 7',
                ],
                'expected' => '4 ИЛИ 5 ИЛИ (4 И 5)'
            ],
            [
                'expression' => '7 + 7 =',
                'suitableAnswers' => [
                    '5',
                    '14',
                ],
                'expected' => '2'
            ],
            [
                'expression' => '8 + 8 =',
                'suitableAnswers' => [
                    '16',
                    '12',
                    '9',
                    '5',
                ],
                'expected' => '1'
            ],
            [
                'expression' => '9 + 9 =',
                'suitableAnswers' => [
                    '18',
                    '9',
                    '17 +1',
                    '2 + 16',
                ],
                'expected' => '1 ИЛИ 3 ИЛИ 4 ИЛИ (1 И 3) ИЛИ (1 И 4) ИЛИ (3 И 4) ИЛИ (1 И 3 И 4)'
            ],
            [
                'expression' => '10 + 10 =',
                'suitableAnswers' => [
                    '0',
                    '2',
                    '8',
                    '20'
                ],
                'expected' => '4'
            ]
        ];
    }
}
