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

function fetch_db_data (mysqli $con, string $sql): ?array
{
    $result = mysqli_query($con, $sql);
    if (!$result) {
        $error =  mysqli_error($con);
        print $page_content = include_template('error.php', ['error' => $error]);
        die();
    } else {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $data;
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

function db_insert_data(mysqli $con, string $sql, array $data = []): ?array
{
    $stmt = db_get_prepare_stmt($con, $sql, $data);
    $result = mysqli_stmt_execute($stmt);
    if($result) {
        $last_userlot_id = mysqli_insert_id($con);
        header("Location: lot.php?id=" . $last_userlot_id);
    } else {
        print $page_content = include_template('error.php', [
            'error' => mysqli_error($con)]);
        die();
    }
    return $result;
}

function show_error () {
    http_response_code('404');
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
