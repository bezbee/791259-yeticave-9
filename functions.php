<?php
function formatPrice ($number) {
    if ($number < 1000) {
        return $number . " ₽";
    } else {
        return number_format($number, 0, ' ', ' ') . " ₽";
    }
};

