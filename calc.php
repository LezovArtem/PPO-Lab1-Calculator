<?php

require_once 'ExpressionValidator.php';
require_once 'ExpressionService.php';
require_once 'CalculatorController.php';

$controller = new CalculatorController();
$data = $controller->handleRequest();
$expression = $data['expression'];
$errorMessage = $data['errorMessage'];

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>PHP Калькулятор выражений</title>
    <style>
        body {
            background: #f0f0f0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .calculator {
            background: #222;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 320px;
        }
        .calculator form {
            display: flex;
            flex-direction: column;
        }
        .screen {
            background: #000;
            color: #0f0;
            font-size: 28px;
            padding: 15px;
            text-align: right;
            border-radius: 10px;
            margin-bottom: 15px;
            border: 2px inset #555;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .buttons button {
            padding: 20px;
            font-size: 18px;
            border: none;
            border-radius: 10px;
            background: #444;
            color: white;
            cursor: pointer;
            transition: background 0.2s;
        }
        .buttons button:hover {
            background: #666;
        }
        .buttons .operator {
            background: #ff9500;
        }
        .buttons .equals {
            grid-column: span 1;
            background: #28a745;
        }
        .buttons .equals:hover {
            background: #3cbf5f;
        }
        .buttons .clear {
            background: #dc3545;
        }
        .buttons .clear:hover {
            background: #f95f6f;
        }
        .error {
            color: #ff6b6b;
            margin-top: 10px;
            text-align: center;
        }
        .result {
            color: #f6e58d;
            text-align: center;
            font-size: 20px;
            margin-top: 10px;
        }
    </style>
    <script>
        function insert(val) {
            const input = document.getElementById('expression');
            const current = input.value;

            const isOperator = /[+\-*/.^%]/.test(val);

            if (current === '0' && !isOperator && val !== '.') {
                // Заменить 0 на цифру
                input.value = val;
            } else {
                input.value += val;
            }
        }

        function clearInput() {
            document.getElementById('expression').value = '0';
        }

        function backspace() {
            const input = document.getElementById('expression');
            if (input.value.length > 1) {
                input.value = input.value.slice(0, -1);
            } else {
                input.value = '0';
            }
        }

        window.onload = function() {
            const input = document.getElementById('expression');
            if (input.value.trim() === '') {
                input.value = '0';
            }
        };
    </script>

</head>
<body>
<div class="calculator">
    <form method="post">
        <input type="text" class="screen" id="expression" name="expression" value="<?= htmlspecialchars($expression) ?>" readonly>

        <div class="buttons">
            <button type="button" onclick="insert('(')">(</button>
            <button type="button" onclick="insert(')')">)</button>
            <button type="button" class="clear" onclick="clearInput()">C</button>
            <button type="button" class="clear" onclick="backspace()">←</button>

            <button class="operator" type="button" onclick="insert('log(')">log</button>
            <button class="operator" type="button" onclick="insert('^')">^</button>
            <button class="operator" type="button" onclick="insert('%')">%</button>
            <button class="operator" type="button" onclick="insert('sqrt(')">√</button>

            <button type="button" onclick="insert('7')">7</button>
            <button type="button" onclick="insert('8')">8</button>
            <button type="button" onclick="insert('9')">9</button>
            <button class="operator" type="button" onclick="insert('/')">/</button>

            <button type="button" onclick="insert('4')">4</button>
            <button type="button" onclick="insert('5')">5</button>
            <button type="button" onclick="insert('6')">6</button>
            <button class="operator" type="button" onclick="insert('*')">*</button>

            <button type="button" onclick="insert('1')">1</button>
            <button type="button" onclick="insert('2')">2</button>
            <button type="button" onclick="insert('3')">3</button>
            <button class="operator" type="button" onclick="insert('-')">-</button>

            <button type="button" onclick="insert('0')">0</button>
            <button type="button" onclick="insert('.')">.</button>
            <button type="submit" class="equals">=</button>
            <button class="operator" type="button" onclick="insert('+')">+</button>
        </div>

        <?php if ($errorMessage): ?>
            <div class="error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>
    </form>
</div>
</body>
</html>

