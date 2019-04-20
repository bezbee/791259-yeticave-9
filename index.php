<?php
require_once('data.php');
require_once('functions.php');
require_once('helpers.php');

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
