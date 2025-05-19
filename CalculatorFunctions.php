<?php

session_start();

if (!isset($_SESSION['memory'])) {
    $_SESSION['memory'] = 0.0;
}

// === МАТЕМАТИЧЕСКИЕ ФУНКЦИИ ===

function sqrt_safe($x) {
    if ($x < 0) {
        throw new Exception("Квадратный корень из отрицательного числа.");
    }
    return sqrt($x);
}

function log_safe($x) {
    if ($x <= 0) {
        throw new Exception("log(x): x должен быть > 0");
    }
    return log10($x);
}

function ln($x) {
    if ($x <= 0) {
        throw new Exception("ln(x): x должен быть > 0");
    }
    return log($x);
}

function ln2($x) {
    if ($x <= 0) {
        throw new Exception("ln2(x): x должен быть > 0");
    }
    return log($x) / log(2);
}

function sin_safe($x) {
    return sin($x);
}

function cos_safe($x) {
    return cos($x);
}

function tg($x) {
    return tan($x);
}

function pow_safe($x, $y) {
    return pow($x, $y);
}

// === ОПЕРАЦИИ С ПАМЯТЬЮ ===

function memAdd($x) {
    $_SESSION['memory'] += $x;
    return 0;
}

function memSub($x) {
    $_SESSION['memory'] -= $x;
    return 0;
}

function memRecall() {
    return $_SESSION['memory'];
}

function memClear() {
    $_SESSION['memory'] = 0.0;
    return 0;
}
