<?php
declare(strict_types = 1);
require_once('init.php');
$lots= [];
$items_per_page = 9;
$cur_page = $_GET['page'] ?? 1;
$offset = ($cur_page - 1) * $items_per_page;

if(!isset($_GET['search'])) {
    show_error();
} else {
    $safe_search = trim(mysqli_real_escape_string($link, $_GET['search']));
    $param = $_GET;
    $param['page'] = '';
    $scriptname = pathinfo('', PATHINFO_BASENAME);
    $query = http_build_query($param);
    $url = "/search.php" . $scriptname . "?" . $query;
    $items_count = db_fetch_single_data($link, 'SELECT COUNT(*) as cnt FROM lot l WHERE l.end_by > NOW() AND MATCH(title, description) AGAINST(?)', [$safe_search]);
    $pages_count = ceil($items_count['cnt'] / $items_per_page);
    $pages = range(1, intval($pages_count));
    $lots = fetch_db_data($link, "SELECT l. id, l.image, l.title, l.end_by, IFNULL(MAX(b.offer), l.starting_price) as price, c.category, COUNT(b.offer) as bid_count FROM lot l JOIN category c ON l.category = c.id  LEFT JOIN bid b ON l.id = b.lot WHERE l.end_by > NOW() AND MATCH(title, description) AGAINST('$safe_search') GROUP BY l.id, l.title, l.starting_price, l.image, l.end_by, c.category Order by l.created_on ASC LIMIT " .$items_per_page . " OFFSET " . $offset);
}

$categories = get_categories($link);
$pagination = include_template('pagination.php',[
    'pages' => $pages?? '',
    'cur_page' => intval($cur_page) ?? '',
    'url' => $url ?? ''
]);
$page_content = include_template('search.php', [
    'lots' => $lots,
    'pages_count' => $pages_count ?? '',
    'pagination' => $pagination
]);
$menu = include_template('menu_lot.php', [
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'main_class' => $main_class = ' ',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Поиск',
    'logo_link' => '/index.php'
]);

print($layout_content);
