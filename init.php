<?php
require_once('functions.php');
require_once('helpers.php');
require_once('data.php');

$link = mysqli_connect('mysql', 'root', 'root', 'yeticave');
mysqli_set_charset($link, "utf8");

if (!$link) {
    $error = mysqli_connect_error();
    print $page_content = include_template('error.php', ['error' => $error]);
    die();
}
