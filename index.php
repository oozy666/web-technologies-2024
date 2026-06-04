<?php
define('TPL_DIR', 'templates/');
define('L_DIR', 'layouts/');

$page = $_GET['page'] ?? 'index';
$params = [];

switch ($page) {
    case 'index':
        $params['title'] = 'Главная страница';
        break;

    case 'catalog':
        $params['title'] = 'Каталог продукции';
        $params['catalog'] = getProductList();
        break;

    case 'about':
        $params['title'] = 'О компании';
        $params['phone'] = '8 (800) 555-35-35';
        break;

    case 'lesson18':
        $params['title'] = 'Практические задания';
        $task = $_GET['task'] ?? null;
        if ($task) {
            $params['tasks'] = getTaskData($task);
        } else {
            $params['tasks'] = getTaskData();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
            $params['text'] = $_POST['text'];
            $params['translit'] = transliterateText($_POST['text']);
        }
        break;

    case 'apicatalog':
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(getProductList(), JSON_UNESCAPED_UNICODE);
        die();

    default:
        header("HTTP/1.0 404 Not Found");
        echo "Страница не найдена (404)";
        die();
}

function getProductList() {
    return [
        [
            'name' => 'Свежее Яблоко',
            'price' => 24,
            'image' => 'apple.png'
        ],
        [
            'name' => 'Сладкий Банан',
            'price' => 12,
            'image' => 'banana.png'
        ],
        [
            'name' => 'Сочный Апельсин',
            'price' => 15,
            'image' => 'orange.png'
        ],
    ];
}

function getNavigationTree() {
    return [
        [
            'title' => 'Главная',
            'link' => 'index.php',
        ],
        [
            'title' => 'Задания',
            'link' => 'index.php?page=lesson18',
            'children' => [
                ['title' => 'Числа 0-10', 'link' => 'index.php?page=lesson18&task=one'],
                ['title' => 'Все города', 'link' => 'index.php?page=lesson18&task=two'],
                ['title' => 'Транслит', 'link' => 'index.php?page=lesson18&task=three'],
                ['title' => 'Города на К', 'link' => 'index.php?page=lesson18&task=six'],
            ]
        ],
        [
            'title' => 'Каталог',
            'link' => 'index.php?page=catalog',
        ],
        [
            'title' => 'О нас',
            'link' => 'index.php?page=about',
        ]
    ];
}

function compileTemplate($templateName, $vars = []) {
    extract($vars);
    ob_start();
    include TPL_DIR . $templateName . ".php";
    return ob_get_clean();
}

echo compileTemplate(L_DIR . 'main', [
    'title' => $params['title'],
    'menu' => compileTemplate('menu', ['menus' => getNavigationTree()]),
    'content' => compileTemplate($page, $params)
]);

function runTaskOne() {
    $i = 0;
    $output = [];
    do {
        if ($i === 0) {
            $output[] = "<p><span class='badge'>$i</span> – это ноль.</p>";
        } elseif ($i % 2 === 0) {
            $output[] = "<p><span class='badge'>$i</span> – чётное число.</p>";
        } else {
            $output[] = "<p><span class='badge'>$i</span> – нечётное число.</p>";
        }
        $i++;
    } while ($i <= 10);
    return $output;
}

function runTaskTwo() {
    $output = [];
    $data = [
        "Московская область" => ["Москва", "Зеленоград", "Клин"],
        "Ленинградская область" => ["Санкт-Петербург", "Всеволожск", "Павловск", "Кронштадт"],
        "Рязанская область" => ["Рязань", "Касимов", "Скопин"],
        "Краснодарский край" => ["Краснодар", "Сочи", "Анапа", "Новороссийск"]
    ];
    foreach ($data as $region => $cities) {
        $output[] = "<p><strong>$region:</strong><br>" . implode(", ", $cities) . ".</p>";
    }
    return $output;
}

function transliterateText($str) {
    $map = [
        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'yo','ж'=>'zh',
        'з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o',
        'п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'kh','ц'=>'ts',
        'ч'=>'ch','ш'=>'sh','щ'=>'shch','ъ'=>'','ы'=>'y','ь'=>'','э'=>'e','ю'=>'yu','я'=>'ya'
    ];
    $map += array_combine(
        array_map('mb_strtoupper', array_keys($map)),
        array_map('ucfirst', array_values($map))
    );
    return strtr($str, $map);
}

function runTaskSix() {
    $output = [];
    $data = [
        "Московская область" => ["Москва", "Зеленоград", "Клин"],
        "Ленинградская область" => ["Санкт-Петербург", "Всеволожск", "Павловск", "Кронштадт"],
        "Рязанская область" => ["Рязань", "Касимов", "Скопин"],
        "Краснодарский край" => ["Краснодар", "Сочи", "Анапа", "Новороссийск"]
    ];

    foreach ($data as $region => $cities) {
        $filtered = array_filter($cities, function($city) {
            return mb_substr($city, 0, 1) === 'К';
        });
        if (!empty($filtered)) {
            $output[] = "<p><strong>$region:</strong><br>" . implode(", ", $filtered) . ".</p>";
        }
    }
    return $output;
}

function getTaskData($task = '') {
    $tasks = [];
    switch ($task) {
        case 'one':
            $tasks[] = runTaskOne();
            break;
        case 'two':
            $tasks[] = runTaskTwo();
            break;
        case 'three':
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
                $tasks[] = [transliterateText($_POST['text'])];
            }
            break;
        case 'six':
            $tasks[] = runTaskSix();
            break;
        default:
            $tasks[] = runTaskOne();
            $tasks[] = runTaskTwo();
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text'])) {
                $tasks[] = [transliterateText($_POST['text'])];
            }
            $tasks[] = runTaskSix();
            break;
    }
    return $tasks;
}
