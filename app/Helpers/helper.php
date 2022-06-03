<?php

use App\Models\Transaction;
use Carbon\Carbon;
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

if (!function_exists('generateInvoiceIn')) {
    function generateInvoiceIn()
    {
        $thnBulan = Carbon::now()->year . Carbon::now()->month;
        if (Transaction::where('status', Transaction::STATUS_IN)->count() === 0) {
            return 'INVIN' . $thnBulan . '10000001';
        } else {
            return 'INVIN' . $thnBulan . (int) substr(Transaction::where('status',
            Transaction::STATUS_IN)->get()->last()->invoice, -8) + 1;
        }
    }
}

if (!function_exists('generateInvoiceOut')) {
    function generateInvoiceOut()
    {
        $thnBulan = Carbon::now()->year . Carbon::now()->month;
        if (Transaction::where('status', Transaction::STATUS_OUT)->count() === 0) {
            return 'INVOUT' . $thnBulan . '10000001';
        } else {
            return 'INVOUT' . $thnBulan . (int) substr(Transaction::where('status',
            Transaction::STATUS_OUT)->get()->last()->invoice, -8) + 1;
        }
    }
}
