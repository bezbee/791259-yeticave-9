<?php
declare(strict_types = 1);
require_once('init.php');
$errors =[
    'cost' => NULL
];

if(!isset($_GET['id'])) {
    show_error();
} else {
    $id = intval($_GET['id']);
    $is_current_user_created = db_fetch_single_data($link, "SELECT user_id from lot where id = '$id'");
    $bid_list = fetch_db_data($link, "SELECT b.lot, b.added_on, b.offer, u.name as name FROM bid b LEFT JOIN user u on b.user_id = u.id WHERE b.lot = '$id' ORDER BY b.added_on DESC LIMIT 10");

    $lot = db_fetch_single_data($link,
        "SELECT l.title, l.description, l.starting_price, l.image, l.end_by, l.bid_step, IFNULL(MAX(b.offer), l.starting_price) as price, c.category FROM lot l 
    LEFT OUTER JOIN bid b ON l.id = b.lot 
    JOIN category  c ON l.category = c.id 
    WHERE l.id = ? 
    GROUP BY l.title, l.description, l.starting_price, l.image, l.end_by, l.bid_step, c.category", [$id]);
     $price_plus_bid = $lot['price'] + $lot['bid_step'];
    if($lot === NULL) {
        show_error();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bid = $_POST['cost'] ?? '';
        $error_count = 0;

        if(!is_int($bid) && $bid <= 0) {
            $errors['cost'] = "Введите целое число больше нуля";
            $error_count++;
        }

        if($bid < $price_plus_bid) {
            $errors['cost'] = "Введите ставку равную или большую сумме текущей цены и минимальной ставки";
            $error_count++;
        }

        if(empty($bid)) {
            $errors['cost']  = 'Введите сумму ставки';
            $error_count++;
        }

        if(!$error_count) {
            $current_user_id = $_SESSION['user']['id'];
            db_insert_data($link, "INSERT into bid (user_id, lot, added_on, offer) VALUES (?, ?,'$now', ?)", [$current_user_id, $id, $bid]);
            header('Location: '.$_SERVER['REQUEST_URI']);


        } else {
            $page_content = include_template('lot.php', [
                'lot' => $lot,
                'price_plus_bid' => $price_plus_bid,
                'errors' => $errors,
                'form_class' => 'form--invalid',
                'bid_list' => $bid_list,
                'is_current_user_created' => $is_current_user_created
            ]);
        }
    }
};

$categories = fetch_db_data($link, 'SELECT category, class FROM category');

$menu = include_template('menu_lot.php',[
    'categories' => $categories
]);

$page_content = include_template('lot.php', [
    'lot' => $lot,
    'price_plus_bid' => $price_plus_bid,
    'form_class' => '',
    'errors' => $errors,
    'bid_list' => $bid_list,
    'is_current_user_created' => $is_current_user_created
]);

$layout_content = include_template('layout.php', [
    'main_class' => $main_class = ' ',
    'menu' => $menu,
    'content' => $page_content,
    'categories' => $categories,
    'lot' => $lot,
    'title' => $lot['title'],
    'logo_link' => "/index.php"
]);

print($layout_content);
