<?php
function power($val, $pow) {
    if ($pow === 0) {
        return 1;
    }
    if ($pow < 0) {
        return 1 / power($val, -$pow);
    }
    return $val * power($val, $pow - 1);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/assets/styles/style.css">
    <title>Задание 6</title>
</head>
<body>
    <div class="task-result-box">
        <h2>Практическая 17: Задача 6</h2>
        <p>3<sup>4</sup> = <?= power(3, 4) ?></p>
        <p>2<sup>-3</sup> = <?= power(2, -3) ?></p>
    </div>
</body>
</html>
