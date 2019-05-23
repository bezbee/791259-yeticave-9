<?php
require_once('init.php');

$get_expired_lot_and_winner_id = fetch_db_data($link, 'SELECT lot_and_max_offer_id.*, b.user_id from (SELECT l.id, MAX(b.id) as max_offer_id FROM bid b join lot l on b.lot = l.id  WHERE l.end_by <= now() and l.winner IS NULL group by l.id) as lot_and_max_offer_id join bid b on lot_and_max_offer_id.max_offer_id = b.id;
');

var_dump($get_expired_lot_and_winner_id);

foreach($get_expired_lot_and_winner_id as $key) {
    db_insert_data($link, 'UPDATE lot l SET l.winner = ?, l.winner_bid_id = ? WHERE l.id = ?', [$key['user_id'], $key['max_offer_id'], $key['id']]);
}
