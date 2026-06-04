<?php
function render($page, $params = []) {
    return renderTemplate(LAYOUTS_DIR . 'main', [
        'title' => $params['title'] ?? '',
        'menu' => renderTemplate('menu', $params),
        'content' => renderTemplate($page, $params)
    ]);
}

function renderTemplate($page, $params = []) {
    extract($params);
    ob_start();
    include TEMPLATES_DIR . $page . ".php";
    return ob_get_clean();
}

function createThumbnail($sourcePath, $destPath, $w, $h) {
    $meta = getimagesize($sourcePath);
    if (!$meta) {
        return 'Файл не является изображением';
    }

    $mime = $meta['mime'];
    switch ($mime) {
        case 'image/jpeg': $img = imagecreatefromjpeg($sourcePath); break;
        case 'image/png':  $img = imagecreatefrompng($sourcePath); break;
        case 'image/gif':  $img = imagecreatefromgif($sourcePath); break;
        case 'image/webp': $img = imagecreatefromwebp($sourcePath); break;
        default: return 'Неподдерживаемый формат картинки';
    }

    $srcW = $meta[0];
    $srcH = $meta[1];

    $thumb = imagecreatetruecolor($w, $h);
    imagecopyresampled($thumb, $img, 0, 0, 0, 0, $w, $h, $srcW, $srcH);

    switch ($mime) {
        case 'image/jpeg': imagejpeg($thumb, $destPath); break;
        case 'image/png':  imagepng($thumb, $destPath); break;
        case 'image/gif':  imagegif($thumb, $destPath); break;
        case 'image/webp': imagewebp($thumb, $destPath); break;
    }

    imagedestroy($thumb);
    imagedestroy($img);
    return true;
}

function uploadImage($file) {
    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!in_array($file['type'], $allowed)) {
        return 'Тип файла не поддерживается';
    }

    $limit = 10 * 1024 * 1024;
    if ($file['size'] > $limit) {
        return 'Размер файла превышает 10 МБ';
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return 'Ошибка при загрузке файла на сервер';
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = uniqid('file_', true) . '.' . $ext;

    $bigDir = BASE_PATH . '/images/big/';
    $smallDir = BASE_PATH . '/images/small/';

    if (!is_dir($bigDir)) mkdir($bigDir, 0755, true);
    if (!is_dir($smallDir)) mkdir($smallDir, 0755, true);

    $bigPath = $bigDir . $newName;
    if (!move_uploaded_file($file['tmp_name'], $bigPath)) {
        return 'Ошибка сохранения оригинала';
    }

    $smallPath = $smallDir . $newName;
    $res = createThumbnail($bigPath, $smallPath, 300, 300);
    if ($res !== true) {
        unlink($bigPath);
        return $res;
    }

    return 'Файл успешно загружен';
}

function outputImageByAbsolutePath($path) {
    if (!file_exists($path) || !is_file($path)) {
        header("HTTP/1.0 404 Not Found");
        exit('Изображение не найдено');
    }

    $real = realpath($path);
    $base = realpath(BASE_PATH . '/images');

    if ($real === false || strpos($real, $base) !== 0) {
        header("HTTP/1.0 403 Forbidden");
        exit('Доступ запрещен');
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $real);
    finfo_close($finfo);

    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($real));
    readfile($real);
    exit;
}
