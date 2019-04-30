<?php
$link = mysqli_connect('mysql', 'root', 'root', 'yeticave');
mysqli_set_charset($link, "utf8");

if (!$link) {
    echo mysqli_connect_error();
    die();
}
