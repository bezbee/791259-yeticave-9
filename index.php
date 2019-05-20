<?php
declare(strict_types = 1);
//В сценарии главной страницы выполните подключение к MySQL;
require_once('init.php');

//Отправьте SQL-запрос для получения списка новых лотов;
//Используйте эти данные для показа карточек лотов на главной странице;

$lots = fetch_db_data($link,'SELECT l.*, c.category from lot l JOIN category c ON l.category = c.id WHERE end_by > NOW() ORDER BY created_on DESC LIMIT 9');
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
