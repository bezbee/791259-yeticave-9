<?php
require_once('init.php');
require_once('vendor/autoload.php');

$get_expired_lot_and_winner_id = fetch_db_data($link, 'SELECT lot_and_max_offer_id.*, b.user_id, u.name as user_name, u.email as email from (SELECT l.id as lot_id, l.title as title, MAX(b.id) as max_offer_id FROM bid b join lot l on b.lot = l.id  WHERE l.end_by <= now() and l.winner IS NULL group by l.id) as lot_and_max_offer_id join bid b on lot_and_max_offer_id.max_offer_id = b.id left join user u on b.user_id = u.id;
');

if (!empty($get_expired_lot_and_winner_id)) {
    foreach ($get_expired_lot_and_winner_id as $user) {
        $email = $user['email'];
        $title = $user['title'];
        $user_name = $user['user_name'];
        $lot_id = $user['lot_id'];
        // Конфигурация траспорта
        $transport = new Swift_SmtpTransport('phpdemo.ru', 25);
        $transport->setUsername("keks@phpdemo.ru");
        $transport->setPassword("htmlacademy");
        // Формирование сообщения
        $message = new Swift_Message("Ваша ставка победила");
        $message->setTo([$email => "Победитель"]);
        $message->setFrom("keks@phpdemo.ru", "YetiCave");
        $msg_content = include_template('email.php', [
            'title' => $title,
            'lot_id' => $lot_id,
            'user_name' => $user_name
        ]);
        $message->setBody($msg_content, 'text/html');
        // Отправка сообщения
        $mailer = new Swift_Mailer($transport);
        $mailer->send($message);
    };

    foreach ($get_expired_lot_and_winner_id as $key) {
        db_insert_data($link, 'UPDATE lot l SET l.winner = ?, l.winner_bid_id = ? WHERE l.id = ?',
            [$key['user_id'], $key['max_offer_id'], $key['lot_id']]);
    }
}

