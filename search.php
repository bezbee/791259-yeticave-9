<?php
declare(strict_types = 1);
require_once('init.php');
$lots= [];

if(!isset($_GET['search'])) {
    show_error();
} else {
    $search = trim($_GET['search']);
    if ($search) {
        $sql = 'SELECT l. id, l.image, l.title, l.end_by, IFNULL(MAX(b.offer), l.starting_price) as price, c.category, COUNT(b.offer) as bid_count FROM lot l JOIN category c ON l.category = c.id  LEFT JOIN bid b ON l.id = b.lot WHERE MATCH(title, description) AGAINST(?) GROUP BY l.id, l.title, l.starting_price, l.image, l.end_by, c.category Order by l.created_on ASC Limit 9 ';
        $stmt = db_get_prepare_stmt($link, $sql, [$search]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

$page_content = include_template('search.php', [
    'lots' => $lots
]);
$menu = include_template('menu_lot.php');

$layout_content = include_template('layout.php', [
    'main_class' => $main_class = ' ',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => get_categories($link),
    'title' => 'Поиск',
    'logo_link' => '/index.php'
]);

print($layout_content);
