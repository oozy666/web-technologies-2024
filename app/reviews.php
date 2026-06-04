<?php
if (!isset($pdo)) {
    require_once __DIR__ . '/db.php';
}

function doFeedbackAction($action, $params = []) {
    global $pdo;

    switch ($action) {
        case 'create':
            $stmt = $pdo->prepare("INSERT INTO reviews (product_id, name, text) VALUES (?, ?, ?)");
            $stmt->execute([$params['product_id'], $params['name'], $params['text']]);
            return $pdo->lastInsertId();

        case 'read':
            $stmt = $pdo->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
            $stmt->execute([$params['product_id']]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        case 'update':
            $stmt = $pdo->prepare("UPDATE reviews SET name = ?, text = ? WHERE id = ?");
            return $stmt->execute([$params['name'], $params['text'], $params['id']]);

        case 'delete':
            $stmt = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
            return $stmt->execute([$params['id']]);

        default:
            return false;
    }
}
