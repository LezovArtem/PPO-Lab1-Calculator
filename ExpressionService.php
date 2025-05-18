<?php

declare(strict_types=1);

final class ExpressionService
{
    private array $allowedFunctions;

    public function __construct()
    {
        $this->allowedFunctions = [
            'sqrt' => function ($x) {
                if ($x < 0) throw new Exception("Квадратный корень из отрицательного числа.");
                return sqrt($x);
            },
            'log' => function ($x) {
                if ($x <= 0) throw new Exception("Логарифм определён только для положительных чисел.");
                return log10($x);
            },
            'pow' => function ($x, $y) {
                return pow($x, $y);
            },
        ];
    }

    public function prepare(string $expr): string
    {
        $expr = preg_replace('/\s+/', '', $expr);
        $expr = preg_replace('/(\d+)%/', '($1/100)', $expr);

        while (preg_match('/(\d+|\(.+?\))\^(\d+|\(.+?\))/', $expr)) {
            $expr = preg_replace('/(\d+|\(.+?\))\^(\d+|\(.+?\))/', 'pow($1,$2)', $expr, 1);
        }

        return $expr;
    }

    public function evaluate(string $expr): float
    {
        $code = 'return ' . $expr . ';';

        $evalFunc = function () use ($code) {
            extract($this->allowedFunctions);
            return eval($code);
        };

        $result = $evalFunc();

        if ($result === false) {
            throw new Exception("Ошибка в выражении.");
        }

        return $result ?? 0;
    }
}
