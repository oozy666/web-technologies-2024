<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="navigation-panel">
        <?= $menu ?>
    </div>
    <div class="content-panel">
        <?= $content ?>
    </div>
</body>
</html>
