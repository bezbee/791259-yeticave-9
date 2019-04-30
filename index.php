<?php
require_once('functions.php');
require_once('helpers.php');

//В сценарии главной страницы выполните подключение к MySQL;
require_once('init.php');

//Отправьте SQL-запрос для получения списка новых лотов;
//Используйте эти данные для показа карточек лотов на главной странице;

if (!$link) {
    print ("Ошибка: " .mysqli_connect_error());
}
else {
    print ("Соединения установлено");
    $sql = 'SELECT category, class FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        print("Ощибка запроса: " . mysqli_error($link));
    }
};


if (!$link) {
    print ("Ошибка: " .mysqli_connect_error());
}
else {
    print ("Соединения установлено");
    $sql = 'SELECT l.title, l.starting_price, l.image, MAX(b.offer) as price, c.category FROM lot l
JOIN bid b ON l.id = b.lot
JOIN category  c ON l.category = c.id
WHERE end_by > NOW()
group by l.id, l.title, l.starting_price, l.image, c.category LIMIT 9';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        print("Ощибка запроса: " . mysqli_error($link));
    }
};

//Отправьте SQL-запрос для получения списка категорий;
//Используйте эти данные для показа списка категорий на главной странице вверху и в футере страницы.

if (!$link) {
    print ("Ошибка: " .mysqli_connect_error());
}
else {
    print ("Соединения установлено");
    $sql = 'SELECT category, class FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        print("Ощибка запроса: " . mysqli_error($link));
    }
};


$page_content = include_template('index.php', [
    'lots' => $lots,
    'categories' => $categories
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Yeticave - Главная'
]);
print($layout_content);
