<?php
$x = 12;
$y = 6;

if ($x >= 0 && $y >= 0) {
    $out = $x - $y;
} elseif ($x < 0 && $y < 0) {
    $out = $x * $y;
} else {
    $out = $x + $y;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/assets/styles/style.css">
    <title>Задание 1</title>
</head>
<body>
    <div class="task-result-box">
        <h2>Практическая 17: Задача 1</h2>
        <p>Числа: A = <?= $x ?>, B = <?= $y ?></p>
        <p>Результат вычисления: <?= $out ?></p>
    </div>
</body>
</html>
