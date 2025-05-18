<?php

class CalculatorController
{
    private ExpressionValidator $validator;
    private ExpressionService $expressionService;

    public function __construct()
    {
        $this->validator = new ExpressionValidator();
        $this->expressionService = new ExpressionService();
    }

    public function handleRequest(): array
    {
        $expression = $_POST['expression'] ?? '';
        $result = null;
        $errorMessage = null;

        try {
            $this->validator->validate($expression);
            $processedExpr = $this->expressionService->prepare($expression);
            $result = $this->expressionService->evaluate($processedExpr);
            $expression = (string)$result;
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }

        return [
            'result' => $result,
            'expression' => $expression,
            'errorMessage' => $errorMessage
        ];
    }
}

