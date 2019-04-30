<?php
require_once('functions.php');
require_once('helpers.php');

//В сценарии главной страницы выполните подключение к MySQL;
require_once('init.php');

//Отправьте SQL-запрос для получения списка новых лотов;
//Используйте эти данные для показа карточек лотов на главной странице;

$lots = fetch_db_data($link,'SELECT l.*, c.category from lot l JOIN category c ON l.category = c.id WHERE end_by > NOW() ORDER BY created_on');
$categories = fetch_db_data($link, 'SELECT category, class FROM category');

$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Yeticave - Главная'
]);
print($layout_content);
