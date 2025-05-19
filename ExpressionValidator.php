<?php

declare(strict_types=1);

final class ExpressionValidator
{
    /**
     * @throws Exception
     */
    public function validate(string $expr): void
    {
        if ($expr === '') {
            return;
        }

        if (!preg_match('/^[0-9\.\+\-\*\/\(\)\$%,\^a-zA-Z]+$/', $expr)) {
            throw new Exception("Недопустимые символы в выражении.");
        }

        if (preg_match('/\/\s*0(?![\d\.])/i', $expr)) {
            throw new Exception("Обнаружено деление на ноль.");
        }

        if (preg_match('/%\s*0(?![\d\.])/', $expr)) {
            throw new Exception("Деление по модулю на ноль запрещено.");
        }
    }
}
