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
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/assets/styles/style.css">
    <title>Задание 3</title>
</head>
<body>
    <div class="task-result-box">
        <h2>Практическая 17: Задача 3</h2>
        <ul>
            <li>Сумма (8 + 4): <?= sumNumbers(8, 4) ?></li>
            <li>Разность (8 - 4): <?= subNumbers(8, 4) ?></li>
            <li>Произведение (8 * 4): <?= mulNumbers(8, 4) ?></li>
            <li>Частное (8 / 4): <?= divNumbers(8, 4) ?></li>
        </ul>
    </div>
</body>
</html>
