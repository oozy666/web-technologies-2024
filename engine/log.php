<?php
function logRequest() {
    $dir = BASE_PATH . '/engine/logs';
    $main = "$dir/log.txt";

    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $time = date('Y-m-d H:i:s');
    $line = $time . " | " . $_SERVER['REQUEST_METHOD'] . " " . $_SERVER['REQUEST_URI'] . "\n";

    $count = 0;
    if (file_exists($main)) {
        $count = count(file($main));
    }

    if ($count >= 10) {
        $idx = 1;
        while (file_exists("$dir/log$idx.txt")) {
            $idx++;
        }
        rename($main, "$dir/log$idx.txt");
    }

    file_put_contents($main, $line, FILE_APPEND);
}
