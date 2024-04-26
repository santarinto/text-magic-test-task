<?php


namespace App\Tests\Unit\Service;

use App\Service\AnswerCombinatorService;
use App\Tests\Support\UnitTester;

class AnswerCombinatorServiceTest extends \Codeception\Test\Unit
{

    protected UnitTester $tester;
    private AnswerCombinatorService $answerCombinatorService;

    protected function _before(): void {
        $this->answerCombinatorService = new AnswerCombinatorService();
    }

    /**
     * @dataProvider simpleCombinationsDataProvider
     */
    public function testSimpleCombinations(array $answers, string $expected) {
        $this->setName(json_encode($answers));
        $result = $this->answerCombinatorService->combine($answers);

        $this->assertEquals($expected, $result);
    }

    private function simpleCombinationsDataProvider(): array {
        return [
            [
                [1, 2, 3],
                '1 ИЛИ 2 ИЛИ 3 ИЛИ (1 И 2) ИЛИ (1 И 3) ИЛИ (2 И 3) ИЛИ (1 И 2 И 3)'
            ],
            [
                [
                    6,
                ],
                '6'
            ],
            [
                [
                    10,
                    150,
                    1,
                    2,
                    4,
                ],
                '1 ИЛИ 2 ИЛИ 4 ИЛИ 10 ИЛИ 150 ИЛИ (1 И 2) ИЛИ (1 И 4) ИЛИ (2 И 4) ИЛИ (10 И 1) ИЛИ (10 И 2) ИЛИ (10 И 4) ИЛИ (10 И 150) ИЛИ (150 И 1) ИЛИ (150 И 2) ИЛИ (150 И 4) ИЛИ (1 И 2 И 4) ИЛИ (10 И 1 И 2) ИЛИ (10 И 1 И 4) ИЛИ (10 И 2 И 4) ИЛИ (10 И 150 И 1) ИЛИ (10 И 150 И 2) ИЛИ (10 И 150 И 4) ИЛИ (150 И 1 И 2) ИЛИ (150 И 1 И 4) ИЛИ (150 И 2 И 4) ИЛИ (10 И 1 И 2 И 4) ИЛИ (10 И 150 И 1 И 2) ИЛИ (10 И 150 И 1 И 4) ИЛИ (10 И 150 И 2 И 4) ИЛИ (150 И 1 И 2 И 4) ИЛИ (10 И 150 И 1 И 2 И 4)'
            ],
            [
                [
                    5,
                    10,
                    15,
                ],
                '5 ИЛИ 10 ИЛИ 15 ИЛИ (5 И 10) ИЛИ (5 И 15) ИЛИ (10 И 15) ИЛИ (5 И 10 И 15)'
            ]
        ];
    }
}
