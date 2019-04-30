<?php
$link = mysqli_connect('mysql', 'root', 'root', 'yeticave');
mysqli_set_charset($link, "utf8");

$categories = [];
$content = '';
