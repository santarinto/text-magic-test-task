<?php


namespace App\Tests\Unit\Service;

use App\Domain\Dto\TestAttemptDto;
use App\Service\LinesParserService;
use App\Tests\Support\UnitTester;

class LinesParserServiceTest extends \Codeception\Test\Unit
{
    protected UnitTester $tester;
    private LinesParserService $linesParserService;

    protected function _before(): void {
        $this->linesParserService = new LinesParserService();
    }

    /**
     * @dataProvider parseDataProvider
     */
    public function testParseLines(string $title, string $lines, TestAttemptDto $expected): void {
        $this->setName($title);
        $result = $this->linesParserService->parse(explode(PHP_EOL, $lines));
        $this->tester->assertEquals($expected, $result);
    }

    private function parseDataProvider() {
        return [
            [
                'title' => 'Simple lines',
                'lines' => <<<LINES
1 + 1 =

3
2
0

2
LINES,
                'expected' => new TestAttemptDto(
                    '1 + 1 =',
                    [
                        '3',
                        '2',
                        '0',
                    ],
                    '2'
                )
            ],
            [
                'title' => 'Simple lines with complex compiled answer',
                'lines' => <<<LINES
2 + 2 =

4
3 + 1
10

1 ИЛИ 2 ИЛИ (1 И 2)
LINES,
                'expected' => new TestAttemptDto(
                    '2 + 2 =',
                    [
                        '4',
                        '3 + 1',
                        '10',
                    ],
                    '1 ИЛИ 2 ИЛИ (1 И 2)'
                ),
            ],
        ];
    }
}
