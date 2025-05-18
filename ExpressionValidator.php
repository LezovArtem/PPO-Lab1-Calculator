<?php

declare(strict_types=1);

final class ExpressionValidator
{
    /**
     * @throws Exception
     */
    public function validate(string $expr):  void
    {
        if ($expr === '') {
            return;
        }

        if (!preg_match('/^[0-9\.\+\-\*\/\(\)%,\^sqrtlogpow]+$/', $expr)) {
            throw new Exception("Недопустимые символы в выражении.");
        }
    }
}
