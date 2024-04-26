<?php

namespace App\Tests\Unit\Service;

use App\Service\ArithmeticExpressionParser;
use App\Service\QuizService;
use App\Tests\Support\UnitTester;
use Codeception\Test\Unit;

class QuizServiceTest extends Unit
{

    protected UnitTester $tester;
    private readonly QuizService $quizService;
    private readonly ArithmeticExpressionParser $arithmeticExpressionParser;

    protected function _before(): void {
        $this->quizService = new QuizService();
        $this->arithmeticExpressionParser = new ArithmeticExpressionParser();
    }

    // tests

    /**
     * @dataProvider findRightAnswersProvider
     */
    public function testFindRightAnswers(string $expression, array $inputExpressions, array $expected): void {
        $this->setName($expression);

        $expression = $this->arithmeticExpressionParser->parse($expression);
        $answers = [];

        foreach ($inputExpressions as $inputExpression) {
            $answers[] = $this->arithmeticExpressionParser->parse($inputExpression);
        }

        $rightAnswers = $this->quizService->findRightAnswers($expression, $answers);
        $this->assertCount(count($expected), $rightAnswers);

        foreach ($rightAnswers as $rightAnswer) {
            $this->assertContains($rightAnswer->getExpression(), $expected);
        }
    }

    private function findRightAnswersProvider(): array {
        return [
            [
                '2 + 2 =',
                [
                    '4',
                    '3 + 1',
                    '10',
                ],
                [
                    '4',
                    '3 + 1',
                ]
            ],
            [
                '1 + 1 =',
                [
                    '3',
                    '2',
                    '0',
                ],
                [
                    '2',
                ]
            ],
            [
                '3 + 3 = ',
                [
                    '1 + 5',
                    '1',
                    '6',
                    '2 + 4',
                ],
                [
                    '1 + 5',
                    '6',
                    '2 + 4',
                ],
            ],
            [
                '4 + 4 =',
                [
                    '8',
                    '4',
                    '0',
                    '0 + 8'
                ],
                [
                    '8',
                    '0 + 8'
                ],
            ],
            [
                '5 + 5 = ',
                [
                    '6',
                    '18',
                    '10',
                    '9',
                    '0'
                ],
                [
                    '10',
                ],
            ],
            [
                '6 + 6 =',
                [
                    '3',
                    '9',
                    '0',
                    '12',
                    '5 + 7'
                ],
                [
                    '12',
                    '5 + 7'
                ],
            ],
            [
                '7 + 7 = ',
                [
                    '5',
                    '14'
                ],
                [
                    '14'
                ],
            ],
            [
                '8 + 8 =',
                [
                    '16',
                    '12',
                    '9',
                    '5'
                ],
                [
                    '16',
                ],
            ],
            [
                '9 + 9 = ',
                [
                    '18',
                    '9',
                    '17 + 1',
                    '2 + 16'
                ],
                [
                    '18',
                    '17 + 1',
                    '2 + 16'
                ],
            ],
            [
                '10 + 10 =',
                [
                    '0',
                    '2',
                    '8',
                    '20',
                ],
                [
                    '20',
                ]
            ]
        ];
    }
}
