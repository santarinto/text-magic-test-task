<?php

namespace App\Tests\Unit\Service;

use App\Domain\Dto\ArithmeticExpressionDto;
use App\Exception\WrongArithmeticExpression;
use App\Service\ArithmeticExpressionParser;
use App\Tests\Support\UnitTester;
use Codeception\Test\Unit;

class ArithmeticExpressionParserTest extends Unit
{
    protected UnitTester $tester;
    private readonly ArithmeticExpressionParser $arithmeticExpressionParser;

    protected function _before(): void {
        $this->arithmeticExpressionParser = new ArithmeticExpressionParser();
    }

    /**
     * @dataProvider simpleNumbersProvider
     */
    public function testSimpleNumbers(string $expression, ArithmeticExpressionDto $excepted): void {
        $this->setName($expression);

        $expression = $this->arithmeticExpressionParser->parse($expression);

        $this->assertEquals($excepted->getExpression(), $expression->getExpression());
        $this->assertEquals($excepted->getResult(), $expression->getResult());
    }

    private function simpleNumbersProvider(): array {
        return [
            ['1', new ArithmeticExpressionDto('1', 1)],
            ['2', new ArithmeticExpressionDto('2', 2)],
            ['3', new ArithmeticExpressionDto('3', 3)],
            ['4', new ArithmeticExpressionDto('4', 4)],
            ['5', new ArithmeticExpressionDto('5', 5)],
            ['6', new ArithmeticExpressionDto('6', 6)],
            ['7', new ArithmeticExpressionDto('7', 7)],
            ['8', new ArithmeticExpressionDto('8', 8)],
            ['9', new ArithmeticExpressionDto('9', 9)],
            ['10', new ArithmeticExpressionDto('10', 10)],
        ];
    }

    /**
     * @dataProvider simpleAdditionProvider
     */
    public function testSimpleAddition(string $expression, ArithmeticExpressionDto $excepted): void {
        $this->setName($expression);

        $expression = $this->arithmeticExpressionParser->parse($expression);

        $this->assertEquals($excepted->getExpression(), $expression->getExpression());
        $this->assertEquals($excepted->getResult(), $expression->getResult());
    }

    private function simpleAdditionProvider(): array {
        return [
            ['1 + 2', new ArithmeticExpressionDto('1 + 2', 3)],
            ['2 + 3 =', new ArithmeticExpressionDto('2 + 3 =', 5)],
            ['3 + 4', new ArithmeticExpressionDto('3 + 4', 7)],
            ['4 + 5 = ', new ArithmeticExpressionDto('4 + 5 = ', 9)],
            ['5 + 6', new ArithmeticExpressionDto('5 + 6', 11)],
            ['6 + 7 =', new ArithmeticExpressionDto('6 + 7 =', 13)],
            ['7 + 8', new ArithmeticExpressionDto('7 + 8', 15)],
            ['8 + 9 = ', new ArithmeticExpressionDto('8 + 9 = ', 17)],
            ['9 + 10', new ArithmeticExpressionDto('9 + 10', 19)],
            ['10 + 11 =', new ArithmeticExpressionDto('10 + 11 =', 21)],
        ];
    }

    /**
     * @dataProvider wrongExpressionProvider
     */
    public function testWrongExpression(string $expression): void {
        $this->setName($expression);

        $this->expectExceptionObject(new WrongArithmeticExpression(ArithmeticExpressionParser::WRONG_EXPRESSION_ERROR_MESSAGE));
        $this->arithmeticExpressionParser->parse($expression);
    }

    private function wrongExpressionProvider(): array {
        return [
            ['1 + 2 + 3'],
            ['1 + 2 + 3 ='],
            ['1 + 2 + 3 = 6'],
            ['1 + 2 + 3 = 6 ='],
            ['1 + 2 + 3 = 6 = 7'],
        ];
    }
}
