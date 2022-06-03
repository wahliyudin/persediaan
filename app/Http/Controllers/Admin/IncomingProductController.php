<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class IncomingProductController extends Controller
{
    public function index()
    {
        return view('admin.incoming-product.index', [
            'breadcrumbs' => [
                'title' => 'Barang Masuk',
                'path' => [
                    'Master Data' => route('admin.gudang.index'),
                    'Barang Masuk' => 0
                ]
            ],
            'incoming_products' => Transaction::with('product', 'product.unit', 'product.warehouse')->where('status',
            Transaction::STATUS_IN)->latest()->get()
        ]);
    }
}
