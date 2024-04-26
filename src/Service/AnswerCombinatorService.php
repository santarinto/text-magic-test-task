<?php

namespace App\Service;

use phpDocumentor\Reflection\Types\This;

class AnswerCombinatorService
{
    public const T_OR = 'ИЛИ';
    public const T_AND = 'И';

    /**
     * @param int[] $answers
     * @return string
     */
    public function combine(array $answers): string {
        $combinations = $this->generateCombinations($answers);

        sort($combinations);

        return $this->combinationsImplode($combinations);
    }

    function generateCombinations(array $input): array {
        $result = [];
        $n = count($input);
        $p = 1 << $n;

        for ($i = 1; $i < $p; $i++) {
            $combination = [];

            for ($j = 0; $j < $n; $j++) {
                if ($i & (1 << $j)) {
                    $combination[] = $input[$j];
                }
            }

            $result[] = count($combination) > 1 ? $combination : $combination[0];
        }

        return $result;
    }

    private function combinationsImplode(array $items): string {
        $result = array_map(function ($item) {
            return is_array($item) ? '(' . implode(' ' . self::T_AND . ' ', $item) . ')' : $item;
        }, $items);

        return implode(' ' . self::T_OR . ' ', $result);
    }
}