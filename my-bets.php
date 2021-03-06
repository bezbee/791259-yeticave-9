<?php
declare(strict_types = 1);
include_once('init.php');
$categories = get_categories($link);

$user_id = $_SESSION['user']['id'];
$list_of_user_bids = fetch_db_data($link, 'SElECT b.*, l.title, l.image, l.winner_bid_id, c.category as category, l.end_by, u.contact from bid b join lot l on b.lot = l.id join category c on l.category = c.id JOIN user u on l.user_id = u.id  WHERE b.user_id = ? order by b.added_on DESC', [$user_id]);
if (!isset($_SESSION['user'])) {
    header("http_response_code: 403");
    $error = "Ошибка 403";
    print($page_content = include_template('error.php', ['error' => $error]));
    exit();
} else {
    $page_content = include_template('my-bets.php', [
        'list_of_user_bids' => $list_of_user_bids
        ]);
}

$menu = include_template('menu_lot.php', [
    'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'main_class' => $main_class = ' ',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Мои ставки',
    'logo_link' => "/index.php"
]);

print($layout_content);
