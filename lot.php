<?php
require_once('init.php');

if(!isset($_GET['id'])) {
    show_error();
} else {
    $id = intval($_GET['id']);
    $lot = db_fetch_single_data($link,
        "SELECT l.title, l.description, l.starting_price, l.image, l.end_by, IFNULL(MAX(b.offer), l.starting_price) as price, c.category FROM lot l 
    LEFT OUTER JOIN bid b ON l.id = b.lot 
    JOIN category  c ON l.category = c.id 
    WHERE l.id = ? 
    GROUP BY l.title, l.description, l.starting_price, l.image, l.end_by, c.category", [$id]);
    if($lot == NULL) {
        show_error();
    }
};

$categories = fetch_db_data($link, 'SELECT category, class FROM category');

$menu = include_template('menu_lot.php');

$page_content = include_template('lot.php', [
    'lot' => $lot
]);

$layout_content = include_template('layout.php', [
    'main_class' => $main_class = ' ',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'lot' => $lot,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => $lot['title']
]);

print($layout_content);
