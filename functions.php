<?php
function formatPrice ($number) {
    if ($number < 1000) {
        return $number . " ₽";
    } else {
        return number_format($number, 0, ' ', ' ') . " ₽";
    }
};

function calculateTimeTillMidnight() {
    date_default_timezone_set("America/Boise");
    $ts_midnight = strtotime('tomorrow');
    $secs_to_midnight = $ts_midnight - time();
    $hours = floor($secs_to_midnight / 3600);
    $minutes = floor(($secs_to_midnight % 3600) / 60);
    return $hours . ":" . $minutes;
};

function showTime ($timestamp) {
    $unix = strtotime($timestamp);
    $hours =  floor($unix / 3600);
    $minutes = floor(($unix % 3600)/ 60);
    return $hours . ":" . $minutes;
}

function fetch_db_data ($con, $sql) {
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

function show_error () {
    http_response_code('404');
    $error = "Страница не найдена.";
    print $page_content = include_template('error.php', ['error' => $error]);
    die();
}
