<?php
declare(strict_types = 1);
include_once('init.php');
$categories = get_categories($link);
$errors = [
    'email' => NULL,
    'password' => NULL
];
$error_count = 0;

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите правильный email';
        $error_count++;
    }

    $check_existing_user = db_fetch_single_data($link, "SELECT * from user where email = ?", [filter_var($_POST['email'])]);
    if($check_existing_user) {
        if (password_verify($_POST['password'], $check_existing_user['password'])) {
            session_start();
            $_SESSION['user'] = $check_existing_user;
        } else {
            $errors['password'] = 'Пароль введен неверно';
            $error_count++;
            }
    } else {
        $errors['email'] = 'Пользователь не найден';
    }

    $required_fields = ['email', 'password'];
    foreach($required_fields as $key) {
        if(empty($_POST[$key])) {
            $errors[$key] = 'Это поле обязательно для заполения';
            $error_count++;
        }
    }

    if($error_count) {
        $page_content = include_template('login.php', [
            'errors' => $errors,
            'form_class' => 'form--invalid'
        ]);
    } else {
        header("Location: index.php");
        exit();
    }

}else {
    $page_content = include_template('login.php', [
        'form_class' => '',
        'errors' => $errors
    ]);
}






$menu = include_template('menu_lot.php');

$layout_content = include_template('layout.php', [
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'main_class' => '',
    'logo_link' => '/index.php',
    'title' => 'Пользовательский вход'
]);

print($layout_content);
