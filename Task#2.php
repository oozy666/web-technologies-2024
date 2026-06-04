<?php
$val = rand(0, 15);
$list = "";

switch ($val) {
    case 0: $list .= "0 ";
    case 1: $list .= "1 ";
    case 2: $list .= "2 ";
    case 3: $list .= "3 ";
    case 4: $list .= "4 ";
    case 5: $list .= "5 ";
    case 6: $list .= "6 ";
    case 7: $list .= "7 ";
    case 8: $list .= "8 ";
    case 9: $list .= "9 ";
    case 10: $list .= "10 ";
    case 11: $list .= "11 ";
    case 12: $list .= "12 ";
    case 13: $list .= "13 ";
    case 14: $list .= "14 ";
    case 15: $list .= "15";
        break;
    default:
        $list = "Недопустимое число";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/assets/styles/style.css">
    <title>Задание 2</title>
</head>
<body>
    <div class="task-result-box">
        <h2>Практическая 17: Задача 2</h2>
        <p>Начальное значение: <?= $val ?></p>
        <p>Список чисел: <?= $list ?></p>
    </div>
</body>
</html>
