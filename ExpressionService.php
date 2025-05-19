<?php

require_once 'CalculatorFunctions.php';

class ExpressionService
{
    public function evaluate(string $expression): float|string
    {
        try {
            $prepared = $this->prepare($expression);
            $result = eval("return $prepared;");
            if (!is_numeric($result)) {
                throw new Exception("Невалидный результат.");
            }
            return round($result, 8);
        } catch (Throwable $e) {
            return "Ошибка в выражении: " . $e->getMessage();
        }
    }

    public function prepare(string $expr): string
    {
        $expr = preg_replace('/\s+/', '', $expr);

        // Заменяем ^ на pow_safe
        while (preg_match('/(\d+(?:\.\d+)?|\([^)]+\))\^(\d+(?:\.\d+)?|\([^)]+\))/', $expr)) {
            $expr = preg_replace('/(\d+(?:\.\d+)?|\([^)]+\))\^(\d+(?:\.\d+)?|\([^)]+\))/', 'pow_safe($1,$2)', $expr, 1);
        }

        // Заменяем проценты на деление на 100
        $expr = preg_replace('/(?<=\d)%/', '/100', $expr);

        // Поддержка всех функций: заменяем только имена функций, не трогая аргументы
        $replacements = [
            'sqrt('   => 'sqrt_safe(',
            'log('    => 'log_safe(',
            'ln('     => 'ln(',
            'ln2('    => 'ln2(',
            'sin('    => 'sin_safe(',
            'cos('    => 'cos_safe(',
            'tg('     => 'tg(',
            'pow('    => 'pow_safe(',

            // Операции с памятью
            'M+('     => 'memAdd(',
            'M-('     => 'memSub(',
            'MR'      => 'memRecall()',
            'MC'      => 'memClear()',
        ];


        $expr = str_replace(array_keys($replacements), array_values($replacements), $expr);

        $expr = preg_replace('/(?<!\w)MR(?!\w)/', 'memRecall()', $expr);
        $expr = preg_replace('/(?<!\w)MC(?!\w)/', 'memClear()', $expr);

        return $expr;
    }
}
