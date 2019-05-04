<?php
require_once('init.php');

If (isset($_GET[‘id’])) {
   $id = $_GET[‘id’];
} else {
    http_response_code('404');
    $error = "Нет такой страницы";
    print $page_content = include_template('error.php', ['error' => $error]);
    die();
};

$lot = fetch_db_data($link,'SELECT l.*, c.category from lot l JOIN category c ON l.category = c.id WHERE l.id = "$id"');

$lots_temp = include_template('lot.php', [
    'lot' => $lot
]);

print($lots_temp);
