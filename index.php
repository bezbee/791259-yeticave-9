<?php
declare(strict_types = 1);
//В сценарии главной страницы выполните подключение к MySQL;
require_once('init.php');
require_once('is_winner.php');
require_once('getwinner.php');

//Отправьте SQL-запрос для получения списка новых лотов;
//Используйте эти данные для показа карточек лотов на главной странице;

$categories = fetch_db_data($link, 'SELECT category, class FROM category');
$logo_link = '';

$cat= $_GET['cat'] ?? '';
$is_cat = db_fetch_single_data($link, 'SELECT COUNT(*) as cnt from category where class = ?', [$cat]);


if($cat AND $is_cat['cnt'] === 0) {
    show_error();
}

$dict = [
    'boards' => 'Доски и лыжи',
    'attachment' => 'Крепления',
    'boots' => 'Ботинки',
    'clothing' => 'Одежда',
    'tools' => 'Инструменты',
    'other' => 'Разное'
];

if($cat) {
    $logo_link = 'index.php';
    $condition = "l.end_by > NOW() AND c.class = '$cat'";
    $param = $_GET;
    $param['page'] = '';
    $cur_page = $_GET['page'] ?? 1;
    $scriptname = pathinfo('', PATHINFO_BASENAME);
    $query = http_build_query($param);
    $url = "/" . $scriptname . "?" . $query;
    $items_per_page = 9;
    $offset = ($cur_page - 1) * $items_per_page;
    $result = mysqli_query($link, "SELECT COUNT(*) as cnt FROM lot l JOIN category c on l.category = c.id  WHERE l.end_by > NOW() AND c.class = '$cat'");
    $items_count = mysqli_fetch_assoc($result)['cnt'];
    $pages_count = ceil($items_count / $items_per_page);
    $pages = range(1, $pages_count);
    $lots = fetch_db_data($link, 'SELECT l. id, l.image, l.title, l.end_by, IFNULL(MAX(b.offer), l.starting_price) as price, c.category, c.class, COUNT(b.offer) as bid_count FROM lot l JOIN category c ON l.category = c.id  LEFT JOIN bid b ON l.id = b.lot  WHERE ' .$condition . ' GROUP BY l.id, l.title, l.starting_price, l.image, l.end_by, c.category ORDER BY l.created_on DESC LIMIT ' . $items_per_page .' OFFSET ' . $offset);
    $pagination = include_template('pagination.php',[
        'pages' => $pages,
        'cur_page' => $cur_page,
        'url' => $url
    ]);
} else {
    $lots = fetch_db_data($link,
        'SELECT l. id, l.image, l.title, l.end_by, IFNULL(MAX(b.offer), l.starting_price) as price, c.category, c.class, COUNT(b.offer) as bid_count FROM lot l JOIN category c ON l.category = c.id  LEFT JOIN bid b ON l.id = b.lot  WHERE l.end_by > NOW() GROUP BY l.id, l.title, l.starting_price, l.image, l.end_by, c.category ORDER BY l.created_on DESC LIMIT 9');
    $pages_count = '';
    $pagination = '';
};

$menu = include_template('menu_index.php', [
    'categories' => $categories
]);
$page_content = include_template('index.php', [
    'lots' => $lots,
    'cat' => $cat,
    'dict' => $dict,
    'pages_count' => $pages_count,
    'pagination' => $pagination
]);
$layout_content = include_template('layout.php', [
    'main_class' => $main_class = 'container',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная',
    'logo_link' => $logo_link
]);
print($layout_content);
