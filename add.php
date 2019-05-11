<?php
declare(strict_types = 1);
require_once('init.php');
$category = $_POST['category'] ?? '';
$categories = get_categories($link);

$last_userlot_id = '';


$errors = [
    'category' => NULL,
    'lot-name'  => NULL,
    'message' => NULL,
    'lot-rate' => NULL,
    'lot-step' => NULL,
    'lot-date' => NULL,
    'lot-image' => NULL
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_lot = $_POST;
    $required = ['category', 'lot-name', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $error_count = 0;

    if($_POST['lot-rate'] <= 0) {
        $errors['lot-rate'] = "Введите число больше нуля";
        $error_count++;
    }

    if(!is_int($_POST['lot-step']) && $_POST['lot-step'] <= 0) {
        $errors['lot-step'] = "Введите целое число больше нуля";
        $error_count++;
    }

    if(is_date_valid($_POST['lot-date']) === false) {
        $errors['lot-date'] = "Введите дату в формате ГГГГ-ММ-ДД";
        $error_count++;
    }

    if(new DateTime($_POST['lot-date']) < new DateTime()) {
        $errors['lot-date'] = "Введите дату в будущем";
        $error_count++;
    }

    if(date_diff_days($_POST['lot-date'], 'now') < 1 ) {
        $errors['lot-date'] = "Введите дату большe текущей на 1 день";
        $error_count++;
    }

    foreach ($required as $key) {
        if(empty($_POST[$key])) {
            $errors[$key] = 'Это поле обязательно для заполнения';
            $error_count++;
        }
    }

    if(isset($_FILES['lot-image'])) {
        $tmp_name = $_FILES['lot-image']['tmp_name'];
        $path = $_FILES['lot-image']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== "image/png" && $file_type !== "image/jpeg") {
            $errors['lot-image'] = 'Загрузите файл в формате jpeg или png';
            $error_count++;
        } else {
            move_uploaded_file($tmp_name, 'uploads/' . $path);
            $user_lot['path'] = 'uploads/' . $path;
        }
    }
    else {
        $errors['lot-image'] = 'Вы не загрузили файл';
        $error_count++;
    }

    if($error_count) {
        $page_content = include_template('add.php', [
            'user_lot' => $user_lot,
            'errors' => $errors,
            'categories'=> $categories,
            'form_class' => 'form--invalid',
            'category' => $category
        ]);
    }
    else {
        $last_userlot_id = db_insert_data($link,"INSERT into lot (user_id, category, created_on, title, description, image, starting_price, end_by, bid_step) VALUES (2, ?, NOW(), ?, ?, ?, ?, ?, ? )", [$category, $user_lot['lot-name'], $user_lot['message'], $user_lot['path'], $user_lot['lot-rate'], $user_lot['lot-date'], $user_lot['lot-step']]);
        header("Location: lot.php?id=" . $last_userlot_id);
    }
}
else {
    $page_content = include_template('add.php', [
        'categories'=> $categories,
        'form_class' => '',
        'errors' => $errors,
        'category' => $category
    ]);
}

$menu = include_template('menu_lot.php');

$layout_content = include_template('layout.php', [
    'main_class' => $main_class = ' ',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Добавить лот',
    'logo_link' => '/index.php'
    ]);

print($layout_content);
