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
        require_once BASE_PATH . '/app/create_db.php';
        $stmt = $pdo->query("SELECT * FROM products ORDER BY id ASC");
        $params['catalog'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        break;

    case 'product':
        $id = (int)($_GET['id'] ?? 0);
        require_once BASE_PATH . '/app/create_db.php';
        require_once BASE_PATH . '/app/reviews.php';

        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            header("HTTP/1.0 404 Not Found");
            echo "Товар не найден";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_GET['action'] ?? '';
            if ($action === 'add_review') {
                $name = trim($_POST['name'] ?? '');
                $text = trim($_POST['text'] ?? '');
                if ($name !== '' && $text !== '') {
                    doFeedbackAction('create', [
                        'product_id' => $id,
                        'name' => $name,
                        'text' => $text
                    ]);
                }
            } elseif ($action === 'delete_review') {
                $reviewId = (int)($_POST['review_id'] ?? 0);
                doFeedbackAction('delete', ['id' => $reviewId]);
            } elseif ($action === 'edit_review') {
                $reviewId = (int)($_POST['review_id'] ?? 0);
                $name = trim($_POST['name'] ?? '');
                $text = trim($_POST['text'] ?? '');
                if ($name !== '' && $text !== '') {
                    doFeedbackAction('update', [
                        'id' => $reviewId,
                        'name' => $name,
                        'text' => $text
                    ]);
                }
            }
            header("Location: index.php?page=product&id=" . $id);
            exit;
        }

        $params['title'] = $product['name'];
        $params['product'] = $product;
        $params['reviews'] = doFeedbackAction('read', ['product_id' => $id]);
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
