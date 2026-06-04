<?php
function sumNumbers($x, $y) {
    return $x + $y;
}

function subNumbers($x, $y) {
    return $x - $y;
}

function mulNumbers($x, $y) {
    return $x * $y;
}

function divNumbers($x, $y) {
    if ($y == 0) {
        return "Деление на ноль невозможно";
    }
    return $x / $y;
}

function mathOperation($arg1, $arg2, $operation) {
    switch ($operation) {
        case "add":
            return sumNumbers($arg1, $arg2);
        case "subtract":
            return subNumbers($arg1, $arg2);
        case "multiply":
            return mulNumbers($arg1, $arg2);
        case "divide":
            return divNumbers($arg1, $arg2);
        default:
            return "Неизвестное действие";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/assets/styles/style.css">
    <title>Задание 4</title>
</head>
<body>
    <div class="task-result-box">
        <h2>Практическая 17: Задача 4</h2>
        <p>12 + 4 = <?= mathOperation(12, 4, "add") ?></p>
        <p>12 - 4 = <?= mathOperation(12, 4, "subtract") ?></p>
        <p>12 * 4 = <?= mathOperation(12, 4, "multiply") ?></p>
        <p>12 / 4 = <?= mathOperation(12, 4, "divide") ?></p>
    </div>
</body>
</html>
