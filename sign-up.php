<?php
declare(strict_types = 1);
require_once('init.php');

$errors = [
    'email' => NULL,
    'password'  => NULL,
    'name' => NULL,
    'message' => NULL
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' AND !isset($_SESSION['user']))  {

    $required = ['email', 'password', 'name', 'message'];
    $error_count = 0;

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email  должен быть корреткным";
        $error_count++;
    } else {
        $result = db_fetch_single_data($link, "SELECT count(*) as count_users_with_same_email from user where email = ?", [filter_var($_POST['email'])]);
        if($result['count_users_with_same_email']) {
            $errors['email'] = "Пользователь с таким email уже существует";
            $error_count++;
        }
    }
    foreach ($required as $key) {
        if(empty($_POST[$key])) {
            $errors[$key] = 'Это поле обязательно для заполнения';
            $error_count++;
        }
    }

    if($error_count) {
        $page_content = include_template('sign-up.php', [
            'errors' => $errors,
            'form_class' => 'form--invalid'
        ]);
    } else {
        $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        db_insert_data($link, "INSERT into user (registered_on, email, name, password, contact) VALUES (NOW(), ?, ?, ?, ?)", [$_POST['email'], $_POST['name'], $password_hash, $_POST['message']] );
        header('Location: /login.php');
        exit();
    }

} else {
    if (isset($_SESSION['user'])) {
        header("http_response_code: 403");
        $error = "Ошибка 403";
        print($page_content = include_template('error.php', ['error' => $error]));
        exit(); }
    else {
        $page_content = include_template('sign-up.php', [
            'form_class' => '',
            'errors' => $errors,
        ]);
    }
}

$categories = get_categories($link);
$menu = include_template('menu_lot.php', [
        'categories' => $categories
    ]);

$layout_content = include_template('layout.php', [
    'main_class' => $main_class = ' ',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Регистрация нового аккаунта',
    'logo_link' => '/index.php'
]);

print($layout_content);
