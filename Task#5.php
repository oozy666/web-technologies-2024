<?php
$y1 = date("Y");
$y2 = (new DateTime())->format("Y");
$y3 = date('Y', time());
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/assets/styles/style.css">
    <title>Задание 5</title>
</head>
<body>
    <div class="task-result-box">
        <h2>Практическая 17: Задача 5</h2>
        <p>Вариант 1 (date): <?= $y1 ?></p>
        <p>Вариант 2 (DateTime): <?= $y2 ?></p>
        <p>Вариант 3 (date + time): <?= $y3 ?></p>
    </div>
</body>
</html>
