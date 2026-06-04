<?php
require_once __DIR__ . '/../config/config.php';

session_start();

$page = $_GET['page'] ?? 'index';
$params = [];

switch ($page) {
    case 'index':
        $params['title'] = 'Главная';
        break;

    case 'galery':
        $params['title'] = 'Галерея';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
            $res = uploadImage($_FILES['image']);
            $_SESSION['upload_res'] = $res;
            header('Location: index.php?page=galery');
            exit;
        }

        if (isset($_SESSION['upload_res'])) {
            $params['upload_res'] = $_SESSION['upload_res'];
            unset($_SESSION['upload_res']);
        }

        $smallDir = BASE_PATH . '/images/small/';
        if (is_dir($smallDir)) {
            $params['images'] = array_diff(scandir($smallDir), ['.', '..']);
        } else {
            $params['images'] = [];
        }

        logRequest();
        break;

    case 'catalog':
        $params['title'] = 'Каталог';
        $params['catalog'] = getCatalog();
        break;

    case 'categories':
        $params['title'] = 'Категории';
        require_once BASE_PATH . '/app/create_db.php';
        require_once BASE_PATH . '/app/menu.php';
        $params['pdo'] = $pdo;
        break;

    case 'about':
        $params['title'] = 'О нас';
        $params['phone'] = '8 (800) 555-35-35';
        break;

    default:
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
        exit;
}

echo render($page, $params);
