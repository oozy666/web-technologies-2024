<?php
$siteTitle = "Моя веб-страница на PHP";
$heroTitle = "Приветствуем Вас!";
$yearNow = date("Y");

function getRussianPlural($number, $one, $two, $five) {
    $n = abs($number) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) {
        return $five;
    }
    if ($n1 > 1 && $n1 < 5) {
        return $two;
    }
    if ($n1 == 1) {
        return $one;
    }
    return $five;
}

function formatCurrentTime() {
    $hours = (int)date('G');
    $minutes = (int)date('i');

    $hWord = getRussianPlural($hours, 'час', 'часа', 'часов');
    $mWord = getRussianPlural($minutes, 'минута', 'минуты', 'минут');

    return "$hours $hWord $minutes $mWord";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $siteTitle; ?></title>
    <link rel="stylesheet" href="src/assets/styles/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?= $heroTitle; ?></h1>
        </header>
        
        <main>
            <section class="time-section">
                <h2>Текущее время:</h2>
                <p><?= formatCurrentTime(); ?></p>
            </section>
        </main>

        <footer>
            <p>&copy; <?= $yearNow; ?> Все права защищены.</p>
        </footer>
    </div>
</body>
</html>
