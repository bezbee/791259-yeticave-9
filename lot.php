<?php
require_once('init.php');

$id = intval($_GET['id']);

$result = mysqli_query($link, "SELECT * FROM lot WHERE id = '$id'");
$records_count = mysqli_num_rows($result);

if(isset ($id) && $records_count !== 0) {
    $lot = db_fetch_single_data($link,
        "SELECT l.*, c.category from lot l JOIN category c ON l.category = c.id WHERE l.id = ?", [$id]);
} else {
    http_response_code('404');
    $error = "Страница не найдена.";
    print $page_content = include_template('error.php', ['error' => $error]);
    die();
};

$categories = fetch_db_data($link, 'SELECT category, class FROM category');

$page_content = include_template('lot.php', [
    'lot' => $lot
]);

$layout_content = include_template('layout-lot.php', [
    'content' => $page_content,
    'categories' => $categories,
    'lot' => $lot
]);

print($layout_content);
