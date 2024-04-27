<?php

namespace App\Service;

use App\Domain\Dto\TestAttemptDto;
use App\Exception\BadFormatRawData;

readonly class LinesParserService
{
    const ERROR_MESSAGE_BAD_PARSE_EXPRESSION = 'On this line should be an expression';
    const ERROR_MESSAGE_BAD_PARSE_RESULT = 'On this line should be an result';
    const ERROR_MESSAGE_BAD_PARSE_COMPILED_RESULT = 'On this line should be an compiled result';

    /**
     * Input lines example:
     * 1 + 1 =
     *
     * 3
     * 2
     * 0
     *
     * 2
     *
     * 0 - expression
     * 1 - blank line
     * n - results
     * n+1 - blank line
     * last - expected result
     */
    public function parse(array $lines): TestAttemptDto {
        $countLines = count($lines);

        $expression = null;
        $results = [];
        $compiledAnswer = null;

        for ($i = 0; $i < $countLines; $i++) {
            switch ($i) {
                case 0:
                    if ($lines[$i] === '') {
                        throw new BadFormatRawData(self::ERROR_MESSAGE_BAD_PARSE_EXPRESSION);
                    }

                    $expression = $lines[$i];
                    break;
                case $countLines - 2:
                case 1:
                    break;
                case $countLines - 1:
                    if ($lines[$i] === '') {
                        throw new BadFormatRawData(self::ERROR_MESSAGE_BAD_PARSE_RESULT);
                    }

                    $compiledAnswer = $lines[$i];
                    break;
                default:
                    if ($lines[$i] === '') {
                        throw new BadFormatRawData(self::ERROR_MESSAGE_BAD_PARSE_COMPILED_RESULT);
                    }

                    $results[] = $lines[$i];
            }
        }

        return new TestAttemptDto($expression, $results, $compiledAnswer);
    }
}