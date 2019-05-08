<?php
declare(strict_types = 1);

require_once('init.php');
$categories = fetch_db_data($link, 'SELECT * FROM category');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_lot = $_POST;
    $required = ['category', 'lot-name', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $errors = [];
    foreach ($required as $key) {
        if(empty($_POST[$key])) {
            $errors['category'] = 'Введите наименование лота';
            $errors['lot-name'] = 'Выберите категорию';
            $errors['message'] = 'Напишите описание лота';
            $errors['lot-rate'] = 'Введите начальную цену';
            $errors['lot-step'] = 'Введите шаг ставки';
            $errors['lot-date'] = 'Введите дату завершения торгов';
        }
    }

    if(isset($_FILES['lot-image'])) {
        $tmp_name = $_FILES['lot-image']['tmp_name'];
        $path = $_FILES['lot-image']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== "image/png" && $file_type !== "image/jpeg") {
            $errors['lot-image'] = 'Загрузите файл в формате jpeg или png';
        } else {
            move_uploaded_file($tmp_name, 'uploads/' . $path);
            $user_lot['path'] = 'uploads/' . $path;
        }
    }
    else {
        $errors['lot-image'] = 'Вы не загрузили файл';
    }

    if(count($errors)) {
        $page_content = include_template('add.php', [
            'user_lot' => $user_lot,
            'errors' => $errors,
            'categories'=> $categories,
            'form_class' => $form_class = 'form--invalid'
        ]);
    }
    else {
        db_insert_data($link,"INSERT into lot (user_id, category, created_on, title, description, image, starting_price, end_by, bid_step) VALUES (2, ?, NOW(), ?, ?, ?, ?, ?, ? )", [$user_lot['category'], $user_lot['lot-name'], $user_lot['message'], $user_lot['path'], $user_lot['lot-rate'], $user_lot['lot-date'], $user_lot['lot-step']]);
        /*
        $sql = "INSERT into lot (user_id, category, created_on, title, description, image, starting_price, end_by, bid_step) VALUES (2, ?, NOW(), ?, ?, ?, ?, ?, ? )";
        $stmt = db_get_prepare_stmt($link, $sql, [$user_lot['category'], $user_lot['lot-name'], $user_lot['message'], $user_lot['path'], $user_lot['lot-rate'], $user_lot['lot-date'], $user_lot['lot-step']]);
        $res = mysqli_stmt_execute($stmt);
        if($res) {
            $last_userlot_id = mysqli_insert_id($link);
            header("Location: lot.php?id=" . $last_userlot_id);
        } else {
            $page_content = include_template('error.php', [
                'error' => mysqli_error($link)]);
        }*/
    }
}
else {
    $page_content = include_template('add.php', [
        'categories'=> $categories,
        'form_class' => $form_class = ''
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
    'title' => 'Добавить лот'
    ]);

print($layout_content);
