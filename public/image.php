<?php
require_once __DIR__ . '/../config/config.php';

if (!isset($_GET['file'])) {
    header("HTTP/1.0 400 Bad Request");
    exit('Файл не указан');
}

outputImageByAbsolutePath($_GET['file']);
