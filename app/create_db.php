<?php
require_once __DIR__ . '/db.php';

$pdo->exec("
    CREATE TABLE IF NOT EXISTS categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        parent_id INT DEFAULT NULL,
        FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$stmt = $pdo->query("SELECT COUNT(*) FROM categories");
if ($stmt->fetchColumn() == 0) {
    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Каталог продукции', NULL)");
    $rootId = $pdo->lastInsertId();

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Электроника', $rootId)");
    $electroId = $pdo->lastInsertId();

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Оргтехника', $rootId)");
    $officeId = $pdo->lastInsertId();

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Смартфоны', $electroId)");
    $phonesId = $pdo->lastInsertId();

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Ноутбуки', $electroId)");
    $laptopsId = $pdo->lastInsertId();

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Apple iPhone 15', $phonesId)");
    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Xiaomi Redmi Note', $phonesId)");

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Игровые модели', $laptopsId)");
    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Тонкие ультрабуки', $laptopsId)");

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Принтеры', $officeId)");
    $printersId = $pdo->lastInsertId();

    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Лазерные', $printersId)");
    $pdo->exec("INSERT INTO categories (name, parent_id) VALUES ('Струйные', $printersId)");
}
