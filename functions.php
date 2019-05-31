<?php
declare(strict_types = 1);

function formatPrice (int $number):string
{
    if ($number < 1000) {
        return $number . " ₽";
    } else {
        return number_format($number, 0, ' ', ' ') . " ₽";
    }
};

function showTime (string $timestamp):string
{
    $unix = strtotime($timestamp);
    $hours =  floor($unix / 3600);
    $minutes = floor(($unix % 3600)/ 60);
    return $hours . ":" . $minutes;
}

function showTimeAddSec (string $timestamp):string
{
    $unix = strtotime($timestamp);
    $hours =  floor($unix / 3600);
    $minutes = floor(($unix % 3600) / 60);
    $seconds = floor(($unix % 3600) / 3600);
    return $hours . ":" . $minutes . ":" . $seconds;
}

function fetch_db_data (mysqli $con, string $sql, array $data = []): ?array
{
    $result = [];
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if (!$res) {
        $error =  mysqli_error($con);
        print $page_content = include_template('error.php', ['error' => $error]);
        die();
    } else {
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }
    return $result;
}

function db_fetch_single_data(mysqli $con, string $sql, array $data = []): ?array
{
    $result = [];
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        $result = mysqli_fetch_assoc($res);
    }
    return $result;
}

function db_insert_data(mysqli $con, string $sql, array $data = []): int
{
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if($result) {
        $result = mysqli_insert_id($con);
    } else {
        print $page_content = include_template('error.php', [
            'error' => mysqli_error($con)]);
        die();
    }
    return $result;
}

function show_error () {
    http_response_code(404);
    $error = "Страница не найдена.";
    print $page_content = include_template('error.php', ['error' => $error]);
    die();
}

function date_diff_days(string $date1, string $date2 = 'now'): int
{
    $dateObj1 = new DateTime($date1);
    $dateObj2 = new DateTime($date2);

    $diff = $dateObj1->diff($dateObj2);

    return (int) $diff->format('%a');
}

function calculate_bid_times (string $time_of_bid) {
    $sec_since_posted = strtotime('now') - strtotime($time_of_bid);
    $h_since_posted = floor($sec_since_posted/3600);
    $min_since_posted = floor(($sec_since_posted % 3600) / 60);
    if ($h_since_posted < 1) {
        echo $min_since_posted . ' мин. назад';
    } else if ($h_since_posted == 1 and $h_since_posted < 2) {
        echo "час назад";
    } else if ($h_since_posted >= 2 and $h_since_posted < 24) {
        echo $h_since_posted . ' ч. назад';
    } else if($h_since_posted >= 24 and $h_since_posted < 48) {
        echo  'вчера в ' . floor($h_since_posted/24) .':' .  $min_since_posted;
    } else {
        echo date_format(date_create($time_of_bid), 'd.m.Y в H:i');
    }
}

function all_null_recursive($arr)
{
    foreach ($arr as $item) {

        /* if the item is an array
           and the function itself found something different from null */
        if (is_array($item) && all_null_recursive($item) === false) {
            return false;

            // if the item is not an array and different from null
        } elseif (!is_array($item) && $item !== null) {
            return false;
        }
    }

    // always found null, everything good
    return true;
}
