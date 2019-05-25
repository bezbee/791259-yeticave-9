<?php
declare(strict_types = 1);
//В сценарии главной страницы выполните подключение к MySQL;
require_once('init.php');
require_once('is_winner.php');

//Отправьте SQL-запрос для получения списка новых лотов;
//Используйте эти данные для показа карточек лотов на главной странице;

$lots = fetch_db_data($link,'SELECT l. id, l.image, l.title, l.end_by, IFNULL(MAX(b.offer), l.starting_price) as price, c.category, COUNT(b.offer) as bid_count FROM lot l JOIN category c ON l.category = c.id  LEFT JOIN bid b ON l.id = b.lot  WHERE l.end_by > NOW() GROUP BY l.id, l.title, l.starting_price, l.image, l.end_by, c.category ORDER BY l.created_on DESC LIMIT 9');
$categories = fetch_db_data($link, 'SELECT category, class FROM category');

$menu = include_template('menu_index.php', [
    'categories' => $categories
]);

$page_content = include_template('index.php', [
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'main_class' => $main_class = 'container',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная',
    'logo_link' => ''
]);
print($layout_content);
