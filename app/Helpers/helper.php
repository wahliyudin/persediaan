<?php

use Illuminate\Support\Str;

if (!function_exists('numberFormat')) {
    function numberFormat($number)
    {
        return number_format($number, 0, ',', '.');
    }
}
if (!function_exists('replaceRupiah')) {
    function replaceRupiah(string $rupiah)
    {
        $rupiah = Str::replace('Rp. ', '', $rupiah);
        return (int) Str::replace('.', '', $rupiah);
    }
}
