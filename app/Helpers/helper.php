<?php

if (!function_exists('numberFormat')) {
    function numberFormat($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
