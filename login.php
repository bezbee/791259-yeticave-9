<?php
declare(strict_types = 1);
include_once('init.php');
$categories = get_categories($link);
$errors = [
    'email' => NULL,
    'password' => NULL
];
$error_count = 0;


if($_SERVER['REQUEST_METHOD'] === 'POST' AND !isset($_SESSION['user'])) {
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Введите правильный email';
        $error_count++;
    } else {
        $user = db_fetch_single_data($link, "SELECT * from user where email = ?",
            [filter_var($_POST['email'])]);
        if ($user) {
            if (password_verify($_POST['password'], $user['password'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Вы ввели неверный email/пароль';
                $error_count++;
            }
        } else {
            $errors['email'] = 'Вы ввели неверный email/пароль';
            $error_count++;
        }
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
        header('Location: index.php');
        exit();
    }

} else {
        if (isset($_SESSION['user'])) {
            header("http_response_code: 403");
            $error = "Ошибка 403";
            print($page_content = include_template('error.php', ['error' => $error]));
            exit(); }
        else {
            $page_content = include_template('login.php', [
                'form_class' => '',
                'errors' => $errors
            ]);
        }
}






$menu = include_template('menu_lot.php', [
    'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'main_class' => '',
    'logo_link' => '/index.php',
    'title' => 'Пользовательский вход'
]);

print($layout_content);
