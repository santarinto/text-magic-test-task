<?php

namespace App\Tests\Unit\Service;

use App\Domain\Dto\ArithmeticExpression;
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

    // tests

    /**
     * @dataProvider simpleNumbersProvider
     */
    public function testSimpleNumbers(string $expression, ArithmeticExpression $excepted): void {
        $expression = $this->arithmeticExpressionParser->parse($expression);
        $this->assertEquals($excepted->getExpression(), $expression->getExpression());
        $this->assertEquals($excepted->getResult(), $expression->getResult());
    }

    private function simpleNumbersProvider(): array {
        return [
            ['1', new ArithmeticExpression('1', 1)],
            ['2', new ArithmeticExpression('2', 2)],
            ['3', new ArithmeticExpression('3', 3)],
            ['4', new ArithmeticExpression('4', 4)],
            ['5', new ArithmeticExpression('5', 5)],
            ['6', new ArithmeticExpression('6', 6)],
            ['7', new ArithmeticExpression('7', 7)],
            ['8', new ArithmeticExpression('8', 8)],
            ['9', new ArithmeticExpression('9', 9)],
            ['10', new ArithmeticExpression('10', 10)],
        ];
    }


    /**
     * @dataProvider simpleAdditionProvider
     */
    public function testSimpleAddition(string $expression, ArithmeticExpression $excepted): void {
        $expression = $this->arithmeticExpressionParser->parse($expression);
        $this->assertEquals($excepted->getExpression(), $expression->getExpression());
        $this->assertEquals($excepted->getResult(), $expression->getResult());
    }

    private function simpleAdditionProvider(): array {
        return [
            ['1 + 2', new ArithmeticExpression('1 + 2', 3)],
            ['2 + 3 =', new ArithmeticExpression('2 + 3 =', 5)],
            ['3 + 4', new ArithmeticExpression('3 + 4', 7)],
            ['4 + 5 = ', new ArithmeticExpression('4 + 5 = ', 9)],
            ['5 + 6', new ArithmeticExpression('5 + 6', 11)],
            ['6 + 7 =', new ArithmeticExpression('6 + 7 =', 13)],
            ['7 + 8', new ArithmeticExpression('7 + 8', 15)],
            ['8 + 9 = ', new ArithmeticExpression('8 + 9 = ', 17)],
            ['9 + 10', new ArithmeticExpression('9 + 10', 19)],
            ['10 + 11 =', new ArithmeticExpression('10 + 11 =', 21)],
        ];
    }

    /**
     * @dataProvider wrongExpressionProvider
     */
    public function testWrongExpression(string $expression): void {
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
